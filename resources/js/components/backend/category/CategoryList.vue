<template>
  <div class="container">
    <div class="w-full">
      <title-section :title="'Informasi kategori berita'" :subtitle="'Semua informasi terkait  berita'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY category -->
      <div class="flex w-full align-middle items-center">
        <div class="w-1/3 border border-grey-light p-8 bg-white rounded">
          <div class="w-full mb-8 block">
            <a href="#" @click.prevent="addCategory()" class="btn-blue btn-md">
              <i class="fa fa-plus"/> Tambah</a>
          </div>
          <table class="table-auto block">
            <thead>
              <tr>
                <th width="350">Nama</th>
                <th>Pilihan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="isLoading">
                <td v-for="n in 5" :key="n"><text-loading></text-loading></td>
              </tr>
              <tr v-if="!isLoading && categorys.length > 0" v-for="(item, index) in categorys" :key="index">
                <td>{{ item.name }}</td>
                <td>
                  <a href="#" @click.prevent="openModalEdit(item)" class="btn-blue btn-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="#" @click.prevent="deleteData(item.id)" class="btn-red btn-sm">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <tr v-if="!isLoading && categorys.length == 0">
                <td colspan="5" align="center">Data Siswa kosong</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- END DISPLAY category -->

      <!-- MODAL CREATE -->
      <modal name="add-category" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah data kategori</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Nama kategori</small>
              <input class="form-default" type="text" v-model="new_data.name" required>
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
      <modal name="edit-category" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Ubah data kategori</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Nama kategori</small>
              <input class="form-default" type="text" v-model="edit_data.name" required>
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
      categorys: false,
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
    this.getCategorys()
  },
  methods: {
    getCategorys() {
      this.isLoading = true
      axios.get('/api/category')
      .then(res => {
        this.isLoading = false
        this.categorys = res.data.results
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          duration: -1000,
          title: 'Ada kesalahan sistem',
          text: 'Data kategori tidak dapat ditampilkan'
        })
      })
    },
    addCategory() {
      this.$modal.show('add-category')
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      
      axios.post('/api/submit-category/', {'data': this.new_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('add-category')
          this.new_data = {}
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data kategori berhasil ditambahkan'
          })
          this.getCategorys()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops Ada kesalahan',
          text: 'Data kategori tidak ditambahkan'
        })
      })

    },
    openModalEdit(item) {
      this.$modal.show('edit-category')
      this.edit_data = item
    },

    updateData() {
      this.isLoadingButton = true
      
      let formData = new FormData()
      
      axios.post('/api/update-category/', {'data': this.edit_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('edit-category')
          this.edit_data = {}
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data kategori berhasil diubah'
          })
          this.getCategorys()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Data kategori gagal diubah'
        })
      })
    },
    clearData(status) {
      if (status == 'edit') {
        this.$modal.hide('edit-category')
        this.edit_data = {}
      } else if (status == 'add') {
        this.$modal.hide('add-category')
        this.new_data = {}
      }
    },
    deleteData(id) {

      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus kategori ini?, Apabila menghapus kategori ini maka semua berita yang terkait dengan kategori ini juga akan dihapus',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/delete-category/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Kategori berhasil dihapus'
                  });
                  this.getCategorys()
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
                  this.getCategorys()
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
                text: 'Kategori tidak dihapus'
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
