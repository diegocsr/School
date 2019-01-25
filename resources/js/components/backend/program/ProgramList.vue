<template>
  <div class="container">
    <div class="w-full">
     <title-section :title="'Informasi Program Sekolah'" :subtitle="'Semua informasi terkait program sekolah'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY program -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
        <div class="flex justify-between items-center mb-8 block">
          <a href="#" @click.prevent="addProgram()" class="btn-blue btn-md">
            <i class="fa fa-plus"/> Tambah</a>
          <div class="form-default-inline btn-md text-base">Total program : {{ programs.length }}</div>
        </div>

        <card-horizontal-loading v-if="isLoading"></card-horizontal-loading>

        <div class="">
          <div class="flex flex-wrap items-stretch items-center">
            <div class="card-program" v-if="!isLoading && programs.length > 0" v-for="(item, index) in programs" :key="index">
              <div class="program">
                <div class="m-auto w-3/3 text-center" style="top: 25%; position: relative">
                  <a href="#" @click.prevent="openModalEdit(item)" title="Ubah data program">
                    <i class="fa fa-edit btn-round bg-green hover:bg-green-dark"/>
                  </a>
                  <a href="#" @click.prevent="deleteData(item.id)" title="Hapus program sekolah">
                    <i class="fa fa-trash btn-round bg-red hover:bg-red-dark"/>
                  </a>
                </div>
              </div>
              <span class="leading-normal">{{ item.description }}</span>
            </div>
            <div v-if="!isLoading && programs.length == 0" class="w-full text-center py-24">
              <spinner-grey class="opacity-50"></spinner-grey>
              <div class="text-2xl text-grey text-center mt-8">Data prestasi tidak dapat ditemukan</div> 
            </div>
          </div>
        </div>

        <!-- <table class="table-auto block">
          <thead>
            <tr>
              <th width="350">Deskripsi</th>
              <th>Pilihan</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="isLoading">
              <td v-for="n in 5" :key="n"><text-loading></text-loading></td>
            </tr>
            <tr v-if="!isLoading && programs.length > 0" v-for="(item, index) in programs" :key="index">
              <td>{{ item.description }}</td>
              <td>
                <a href="#" @click.prevent="openModalEdit(item)" class="btn-blue btn-sm">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="#" @click.prevent="deleteData(item.id)" class="btn-red btn-sm">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
            <tr v-if="!isLoading && programs.length == 0">
              <td colspan="5" align="center">Data program kosong</td>
            </tr>
          </tbody>
        </table> -->
        </div>
      </div>
      <!-- END DISPLAY program -->

      <!-- MODAL CREATE -->
      <modal name="add-program" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah data program</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Deskripsi</small>
              <textarea class="form-default" type="textarea" v-model="new_data.description" required placeholder="Isi dengan program sekolah"/>
            </div>
          </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('add')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="submitData()" class="btn-blue btn-md">
            <i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-blue btn-md"><spinner></spinner></a>
          </div>
        </div>
      </modal>
      <!-- END MODAL CREATE -->

      <!-- MODAL EDIT -->
      <modal name="edit-program" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Ubah data program  </div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Deskripsi</small>
              <textarea class="form-default" type="textarea" v-model="edit_data.description" required autofocus/>
            </div>
          </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('edit')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="updateData()" class="btn-indigo btn-md">
            <i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-blue btn-md"><spinner></spinner></a>
          </div>
        </div>
      </modal>
      <!-- END MODAL EDIT -->

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      programs: false,
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      isError: false,
      error: {
        message: '',
      },
      new_data: {},
      edit_data: {},
    }
  },
  mounted() {
    this.getPrograms()
  },
  methods: {
    getPrograms() {
      this.isLoading = true
      axios.get('/api/program')
      .then(res => {
        this.isLoading = false
        this.programs = res.data.results
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Data program tidak dapat ditampilkan'
        })
      })
    },
    addProgram() {
      this.$modal.show('add-program')
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      
      axios.post('/api/submit-program/', {'data': this.new_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('add-program')
          this.new_data = {}
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data berhasil ditambahkan'
          })
          this.getPrograms()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Error',
          text: 'Data gagal ditambahkan'
        })
      })

    },
    openModalEdit(item) {
      this.$modal.show('edit-program')
      this.edit_data = item
    },

    updateData() {
      this.isLoadingButton = true
      
      let formData = new FormData()
      
      axios.post('/api/update-program/', {'data': this.edit_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('edit-program')
          this.edit_data = {}
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data berhasil diubah'
          })
          this.getPrograms()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Data guru gagal diubah'
        })
      })
    },
    clearData(status) {
      if (status == 'edit') {
        this.$modal.hide('edit-program')
        this.edit_data = {}
      } else if (status == 'add') {
        this.$modal.hide('add-program')
        this.new_data = {}
      }
    },
    deleteData(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus data program ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/delete-program/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Data program berhasil dihapus'
                  });
                  this.getPrograms()
                })
                .catch(err => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'error',
                    title: 'Oops ada kesalahan',
                    text: 'Ada kesalahan pada aksi ini'
                  });
                  this.getPrograms()
                })
            }
          },
          {
            title: '❌ Batal',
            handler: () => {
              this.isLoadingButton = false
              this.$modal.hide('dialog')
              this.$notify({
                group: 'notif',
                position: 'top right',
                type: 'warn',
                title: 'Perintah dibatalkan',
                text: 'Data program tidak dihapus'
              });
             }
          }
        ],
        escapeToClose: false
      })
    }
  }
}
</script>

<style scoped>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  width: 100%;
  max-height: 250px;
  background: #f1f5f8;
  object-fit: cover;
  border-radius: 10px;
}
</style>
