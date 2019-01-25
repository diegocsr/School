<template>
  <div class="container">
    <div class="w-full">
      <progress v-if="uploadPercentage > 0" max="100" :value.prop="uploadPercentage" class="w-full"></progress>
      <title-section :title="'Informasi Event Sekolah'" :subtitle="'Semua informasi terkait prestasi guru, murid dan sekolah'"></title-section>

      <!-- NOTIFICATION -->
      <notifications group="notif" />
      <!-- END NOTIFICATION -->

      <!-- FORM ADD EVENT -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
          <a href="/event-sekolah" class="block mb-4" title="Kembali ke daftar event">
            <i class="fa fa-arrow-left btn-round bg-grey hover:bg-grey-dark"/>
          </a>
          <form class="w-full max-w-md">
            <div class="flex flex-wrap">
              <div class="w-full md:w-1/1 px-3">
                <label class="label" for="grid-first-name">
                  Judul
                </label>
                <input class="form-default" id="grid-first-name" type="text" v-model="new_data.title" @input="addEvent" required autofocus>
              </div>
            </div>
            <div class="flex flex-wrap">
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
                <input type="file" class="form-default" @change="onFileChange" required @input="addEvent">
                <small class="text-grey-dark text-xs italic mt-2">Pastikan file foto kurang dari 3 mb dan berformat (jpg, jpeg, png)</small>
                <!-- Error alert -->
                <!-- <div v-if="isError" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ error.message }}</div> -->
                <!-- End Error alert -->
              </div>
            </div>
            <div class="flex flex-wrap">
              <div class="w-full md:w-1/2 px-3">
                <label class="label">
                  Kategori
                </label>
                <div class="relative">
                  <select class="form-default" required v-model="new_data.category" @input="addEvent">
                    <option value="none" disabled>Pilih kategori</option>
                    <option v-for="(item, index) in dataCategory" :key="index" :value="item.id">{{ item.name }}</option>
                  </select>
                  <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                  </div>
                </div>
                 <p class="text-grey-dark text-xs italic mt-3">Pilih kategori event</p>
              </div>
              <div class="w-full md:w-1/2 px-3">
                <label class="label">
                  Status 
                </label>
                <div class="relative">
                  <select class="form-default" required v-model="new_data.status" @input="addEvent">
                    <option value="option" disabled>Pilih status</option>
                    <option :value="1">Publish</option>
                    <option :value="0">Unpublish</option>
                  </select>
                  <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                  </div>
                </div>
                <p class="text-grey-dark text-xs italic mt-3">Status 'Publish' maka data akan langsung ditampilkan ke web, untuk 'unpublish' hanya menyimpan data</p>
              </div>
            </div>
            <div class="flex flex-wrap">
              <div class="w-full px-3">
                <label class="label">
                  Deskripsi
                </label>
                <quill-editor :options="editorOption" class="bg-white" v-model="new_data.description" required @input="addEvent"></quill-editor>
              </div>
            </div>
            <div class="flex flex-wrap mt-6">
              <div class="flex items-center w-full px-3">

                <a v-if="!isLoadingButton" href="/daftar-prestasi" class="btn-grey btn-md mr-3">
                  <i class="fa fa-close"/> Batal
                </a>
                <button v-if="!isLoadingButton" @click="submitData()" type="button" :class="isButtonDisable ? 'text-grey-lightest text-base bg-grey-light rounded py-2 px-6 no-underline cursor-not-allowed' : 'btn-indigo btn-md'" v-bind:disabled="isButtonDisable == true">
                  <i class="fa fa-save"/> Simpan
                </button>
                <a v-if="isLoadingButton" href="#" class="btn-indigo btn-md"><spinner></spinner></a>
              
              </div>
            </div>
            <ul v-if="isError && error" v-for="(item, index) in error" :key="index" class="bg-red-light text-white rounded px-4 py-6 mt-4">
              <li class="ml-6">{{ item[0] }}</li>
            </ul>
          </form>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isAdd: true,
      isShow: false,
      isError: false,
      isLoadingButton: false,
      new_data: {
        image: false,
        status: 'option',
        category: 'none'
      },
      error: {},
      isError: false,
      errorImage: false,
      isButtonDisable: true,
      uploadPercentage: 0,
      dataCategory: {},
      editorOption: {
        placeholder: 'Tuliskan deskripsi tentang prestasi',
        theme: 'snow',
        modules: {
          toolbar: [
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'], 
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            ['blockquote', 'link'],
          ]
        }
      },
    }
  },
  mounted() {
    this.getCategories(),
    this.addEvent()
  },
  methods: {
    addEvent () {
      if (this.new_data.status && this.new_data.title && this.new_data.category && this.new_data.image && this.new_data.description) {
        this.isButtonDisable = false
      } else {
        this.isButtonDisable = true
      }
    },
    getCategories() {
      axios.get('/api/event')
      .then(res => {
        this.dataCategory = res.data.data_category
      })
      .catch(err => {
        alert(err.data.message)
      })
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);
    },
    createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
            vm.new_data.image = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      formData.append('file', this.file)

      axios.post('/api/submit-event/', this.new_data, {
        onUploadProgress: function( progressEvent ) {
          this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) );
        }.bind(this)
      })
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
          this.isError = true
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'warn',
            title: 'Oops ada kesalahan',
            text: 'Silahkan cek kembali input yang anda masukkan'
          })
          this.error = res.data.message
        } else {
          this.isLoadingButton = false
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Berita berhasil ditambahkan'
          })
          setTimeout(() => {
            window.location.href = '/event-sekolah' 
          }, 2000)
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan sistem',
          text: 'Berita gagal ditambahkan'
        })
      })

    },
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