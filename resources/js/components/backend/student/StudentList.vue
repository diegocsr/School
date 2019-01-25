<template>
  <div class="container">
    <div class="w-full">

    <title-section :title="'Informasi Siswa'" :subtitle="'Semua informasi terkait siswa'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY student -->
      <div class="flex w-2/3 align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
        <div class="w-full mb-8 block">
          <a href="#" @click.prevent="addStudent()" class="btn-blue btn-md">
            <i class="fa fa-plus"/> Tambah</a>
          <!-- <a href="#" @click.prevent="addStudent()" class="btn-green btn-md">
            <i class="fa fa-download"/> Import</a> -->
        </div>
        <table class="table-fixed block w-full">
          <thead>
            <tr>
              <th>No</th>
              <th width="350">Nama</th>
              <th>Nis</th>
              <th>Kelas</th>
              <th>Pilihan</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="isLoading">
              <td v-for="n in 5" :key="n"><text-loading></text-loading></td>
            </tr>
            <tr v-if="!isLoading && students.length > 0" v-for="(item, index) in students" :key="index">
              <td>{{ index+1 }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.nis }}</td>
              <td>{{ item.kelas }}</td>
              <td>
                <a href="#" @click.prevent="openModalEdit(item)" class="btn-blue btn-sm">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="#" @click.prevent="deleteData(item.id)" class="btn-red btn-sm">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
            <tr v-if="!isLoading && students.length == 0">
              <td colspan="5" align="center">Data Siswa kosong</td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
      <!-- END DISPLAY student -->

      <!-- MODAL CREATE -->
      <modal name="add-student" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah data siswa</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Nama</small>
              <input class="form-default" type="text" v-model="new_data.name" autofocus required placeholder="Nama siswa">
              <small class="label mt-6">Nis</small>
              <input class="form-default" type="number" min="0" v-model="new_data.nis" required placeholder="00001">
              <small class="label mt-6">Kelas</small>
              <input class="form-default" placeholder="2A" type="text" v-model="new_data.kelas" required>
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
      <modal name="edit-student" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Ubah data siswa</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Nama</small>
              <input class="form-default" type="text" v-model="edit_data.name" required>
              <small class="label mt-6">Nis</small>
              <input class="form-default" type="number" v-model="edit_data.nis" required>
              <small class="label mt-6">Kelas</small>
              <input class="form-default" type="text" v-model="edit_data.kelas" required>
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
      students: false,
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
    this.getStudents()
  },
  methods: {
    getStudents() {
      this.isLoading = true
      axios.get('/api/student')
      .then(res => {
        this.isLoading = false
        this.students = res.data.results
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Data siswa tidak dapat ditampilkan'
        })
      })
    },
    addStudent() {
      this.$modal.show('add-student')
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      
      axios.post('/api/submit-student/', {'data': this.new_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('add-student')
          this.new_data = {}
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data berhasil ditambahkan'
          })
          this.getStudents()
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
      this.$modal.show('edit-student')
      this.edit_data = item
    },

    updateData() {
      this.isLoadingButton = true
      
      let formData = new FormData()
      
      axios.post('/api/update-student/', {'data': this.edit_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('edit-student')
          this.edit_data = {}
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data berhasil diubah'
          })
          this.getStudents()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Data siswa gagal diubah'
        })
      })
    },
    clearData(status) {
      if (status == 'edit') {
        this.$modal.hide('edit-student')
        this.edit_data = {}
      } else if (status == 'add') {
        this.$modal.hide('add-student')
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
                axios.post('/api/delete-student/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Data siswa berhasil dihapus'
                  });
                  this.getStudents()
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
                  this.getStudents()
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
