<template>
  <div class="container">
    <progress v-if="uploadPercentage > 0" max="100" :value.prop="uploadPercentage" class="w-full"></progress>
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
              <a href="/album" class="btn-grey btn-md mr-3" title="Tambah prestasi">
                <i class="fa fa-arrow-left"/>
              </a>
              <a href="#" @click.prevent="openModalCreate()" class="btn-indigo btn-md" title="Tambah prestasi">
                <i class="fa fa-plus"/> Tambah Foto
              </a>
            </div>
            <div class="form-default-inline btn-md text-base">Total foto : {{ gallery.length }}</div>
          </div>

          <card-horizontal-loading v-if="isLoading"></card-horizontal-loading>
          
          <div v-if="!isLoading && gallery.length > 0" class="flex flex-wrap items-stretch content-start">
            <div class="w-1/3 pr-6 mb-6" v-for="(item, index) in gallery" :key="index">
              <div class="gal w-full border rounded border-grey-light object-cover relative">
                <img :src="item.image_thumbnail" class="w-full rounded-t" style="height: 220px; object-fit: cover;">
                <div class="galle absolute w-full" style="bottom: 20%;">
                  <div class="m-auto w-3/3 text-center">
                    <a href="#" @click.prevent="deletePhoto(item.id)" title="Hapus foto">
                      <i class="fa fa-trash rounded-full px-4 py-4 no-underline text-white text-xl bg-red hover:bg-red-dark"/>
                    </a>
                  </div>
                </div>
                <div class="text-center text-semibold py-2 px-2 text-sm bg-white">{{ item.name }}</div>
              </div>
            </div>
          </div>

          <div v-if="!isLoading && gallery.length == 0" class="w-full text-center py-24">
            <spinner-grey class="opacity-50"></spinner-grey>
            <div class="text-2xl text-grey text-center mt-8">Album ini belum mempunyai foto</div>  
          </div>

        </div>
      </div>
      <!-- END DISPLAY ACHIEVEMENT -->

      <!-- MODAL CREATE -->
      <modal name="create-photo" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah foto</div>
          <div class="block">
            <div class="w-full md:w-1/1 px-3">
              <label class="label" for="grid-first-name">
                Preview Gambar
              </label>
              <div id="preview">
                <img v-if="new_data.image" :src="new_data.image" class="appearance-none"/>
                <div v-else class="rounded w-full bg-grey flex justify-center items-center text-center" style="height: 250px;">
                  <i class="fa fa-user text-grey-light" style="font-size: 8rem !important;"/>
                </div>
              </div>
              <input type="file" class="form-default" @change="onFileChange"  @input="addEvent">
              <small class="text-grey-dark text-xs italic mt-2">Pastikan file foto kurang dari 3 mb dan berformat (jpg, jpeg, png)</small>
              <!-- Error alert -->
              <!-- <div v-if="isError" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ error.message }}</div> -->
              <!-- End Error alert -->
            </div>
            <div class="w-full">
              <small class="label mt-6">Nama foto</small>
              <input class="form-default" type="text" v-model="new_data.name" @input="addEvent">
            </div>
          </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('add')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="submitData()" :class="isButtonDisable ? 'text-grey-lightest text-base bg-grey-light rounded py-2 px-6 no-underline cursor-not-allowed' : 'btn-indigo btn-md'" v-bind:disabled="isButtonDisable == true"><i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-grey btn-md"><spinner></spinner></a>
          </div>
          <div v-if="isError && error" class="w-full">
            <ul v-for="(item, index) in error" :key="index" class="bg-red-light text-white rounded px-4 py-6 mt-4">
              <li class="ml-6">{{ item[0] }}</li>
            </ul>
          </div>
        </div>
      </modal>
      <!-- END MODAL CREATE -->

    </div> 
  </div>
</template>

<script>
export default {
  props: ['album_id'],
  data() {
    return {
      gallery: {},
      isLoading: false,
      new_data : {
        name: null,
        image: null,
      },
      isLoadingButton: false,
      isButtonDisable: false,
      edit_data: {},
      uploadPercentage: 0,
      error: {},
      isError: false,
    }
  },
  mounted() {
    this.getGallery(),
    this.addEvent()
  },
  methods: {
    getGallery() {
      this.isLoading = true
      axios.get('/api/gallery/'+this.album_id)
      .then(res => {
        this.isLoading = false
        this.gallery = res.data.results
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan pada sistem',
          text: 'Data foto tidak ditampilkan'
        })
      })
    },
    addEvent () {
      if (this.new_data.name && this.new_data.image) {
        this.isButtonDisable = false
      } else {
        this.isButtonDisable = true
      }
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);
    },
    createImage(file) {
        let reader = new FileReader();
        // let vm = this;
        reader.onload = (e) => {
            this.new_data.image = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    submitData() {
      this.isLoadingButton = true
      
      let formData = new FormData()
      
      formData.append('file', this.file)
      
      axios.post('/api/submit-gallery/'+this.album_id, this.new_data, {
        onUploadProgress: function( progressEvent ) {
          this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) )
        }.bind(this)
      })
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'warn',
            title: 'Oops ada kesalahan',
            text: 'Silahkan cek kembali input yang anda masukkan'
          });
          this.isError = true
          this.error = res.data.message
          this.uploadPercentage = 0
          this.new_data = {
            name: null,
            image: null
          }
        } else {
          this.isLoadingButton = false
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Foto berhasil ditambahkan'
          })
          this.$modal.hide('create-photo')
          this.new_data = {
            name: null,
            image: null
          }
          this.uploadPercentage = 0
          this.getGallery()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan pada sistem',
          text: 'Data foto tidak ditambahkan'
        })
      })
    },
    deletePhoto(id) {
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus foto ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.delete('/api/delete-gallery/'+id)
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
      this.$modal.show('create-photo')
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
        this.$modal.hide('create-photo')
        this.new_data = {
          name: null,
          image: null
        }
      }
    },
  }
}
</script>
