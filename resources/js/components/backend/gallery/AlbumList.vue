<template>
  <div class="container">
    <div class="w-full">
      <title-section :title="'Galeri Sekolah'" :subtitle="'Semua informasi terkait galeri sekolah'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY ACHIEVEMENT -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
          <div class="flex justify-between items-center mb-8">
            <div class="flex">
              <a href="#" @click.prevent="openModalCreate()" class="btn-indigo btn-md" title="Tambah prestasi">
                <i class="fa fa-plus"/> Tambah Album
              </a>
            </div>
            <div class="form-default-inline btn-md text-base">Total album : {{ albums.length }}</div>
          </div>

          <card-horizontal-loading v-if="isLoading"></card-horizontal-loading>
          
          <div v-if="!isLoading && albums.length > 0" class="flex flex-wrap items-stretch content-start">
            <a :href="'/galeri/'+item.id+'/detail'" v-for="(item, index) in albums" :key="index" class="self-auto w-1/3 pr-10 no-underline h-auto mb-6 text-black">
              <div class="bg-grey-light py-6 px-8 items-top flex hover:shadow-lg rounded border border-grey-light">
                <div class="flex-2">
                  <div class="text-sm font-semibold text-grey-darker">Album</div>
                  <div class="text-xl font-semibold mb-2">{{ item.name }}</div>
                  <button @click.prevent="openModalUpdate(item)" title="Ubah nama album" class="font-semibold p-1 text-sm mr-1 rounded bg-grey-dark text-white hover:bg-green text-right"><i class="fa fa-edit"></i></button>
                  <button @click.prevent="deleteAlbum(item.id)" title="Hapus album" class="font-semibold p-1 text-sm mr-1 rounded bg-grey-dark text-white hover:bg-red text-right"><i class="fa fa-trash"></i></button>
                </div>
                <div class="flex-1">
                    <div class="text-4xl font-semibold text-right">{{ item.galleries.length }}</div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
      <!-- END DISPLAY ACHIEVEMENT -->

      <!-- MODAL CREATE -->
      <modal name="create-album" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah album</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Nama album</small>
              <input class="form-default" type="text" v-model="new_data.name" required>
            </div>
          </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('add')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="submitData()" class="btn-blue btn-md">
            <i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-grey btn-md"><spinner></spinner></a>
          </div>
        </div>
      </modal>
      <!-- END MODAL CREATE -->

      <!-- MODAL UPDATE -->
      <modal name="edit-album" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Ubah Nama Album</div>
          <div class="flex">
            <div class="w-full">
              <small class="label mt-6">Nama album</small>
              <input class="form-default" type="text" v-model="edit_data.name" required>
            </div>
          </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('add')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="updateData(edit_data.id)" class="btn-blue btn-md">
            <i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-grey btn-md"><spinner></spinner></a>
          </div>
        </div>
      </modal>
      <!-- END MODAL UPDATE -->

    </div> 
  </div>
</template>

<script>
export default {
  data() {
    return {
      galleries: {},
      albums: {},
      isLoading: false,
      new_data : {
        name: null
      },
      isLoadingButton: false,
      edit_data: {}
    }
  },
  mounted() {
    this.getGallery()
  },
  methods: {
    getGallery() {
      this.isLoading = true
      axios.get('/api/album')
      .then(res => {
        this.isLoading = false
        this.albums = res.data.albums
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan pada sistem',
          text: 'Data galeri tidak dapat ditampilkan'
        })
      })
    },
    submitData() {
      this.isLoadingButton = true
      axios.post('/api/submit-album', this.new_data)
      .then(res => {
        this.isLoadingButton = false
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'success',
          title: 'Sukses',
          text: 'Album berhasil ditambahkan'
        })
        this.$modal.hide('create-album')
        this.getGallery()
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan pada sistem',
          text: 'Data album tidak ditambahkan'
        })
      })
    },
    deleteAlbum(id) {
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus album ini?, Apabila menghapus album ini maka semua foto yang terkait dengan album ini juga akan dihapus',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.delete('/api/delete-album/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Album berhasil dihapus'
                  });
                  this.getGallery()
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
                  this.getGallery()
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
                text: 'Album tidak dihapus'
              });
             }
          }
        ],
        escapeToClose: false
      })
    },
    updateData(id) {
      this.isLoadingButton = true
      axios.patch('/api/update-album/'+id, this.edit_data)
      .then(res => {
        this.isLoadingButton = false
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'success',
          title: 'Sukses',
          text: 'Album berhasil diubah'
        })
        this.$modal.hide('edit-album')
        this.getGallery()
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan pada sistem',
          text: 'Data album tidak diubah'
        })
      })
    },
    openModalCreate() {
      this.$modal.show('create-album')
    },
    openModalUpdate(item) {
      this.$modal.show('edit-album')
      this.edit_data = item
    },
    clearData(status) {
      if (status == 'edit') {
        this.$modal.hide('edit-album')
        this.edit_data = {}
      } else if (status == 'add') {
        this.$modal.hide('create-album')
        this.new_data = {
          name: null
        }
      }
    },
  }
}
</script>
