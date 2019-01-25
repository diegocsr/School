<template>
  <div class="container">
    <div class="w-full">

      <title-section :title="'Informasi Prestasi Sekolah'" :subtitle="'Semua informasi terkait prestasi guru, murid dan sekolah'"></title-section>

      <!-- NOTIFICATION -->
      <notifications group="notif" />
      <!-- END NOTIFICATION -->

      <!-- FORM ADD ACHIEVEMENT -->
      <div class="flex w-full align-middle items-center">
        <div class="w-3/4 border border-grey-light p-8 bg-white rounded">
          <a href="/daftar-prestasi" class="block mb-4" title="Kembali ke daftar event">
            <i class="fa fa-arrow-left btn-round bg-grey hover:bg-grey-dark"/>
          </a>
          <form class="w-full max-w-md">
            <div class="flex flex-wrap">
              <div class="w-full md:w-1/1 px-3">
                <label class="label" for="grid-first-name">
                  Judul prestasi
                </label>
                <input class="form-default" id="grid-first-name" type="text" placeholder="Juara 1 Lomba Cerdas Cermat Tingkat Kota" v-model="data.title" @input="addEvent">
              </div>
            </div>
            <div class="flex flex-wrap">
              <div class="w-full md:w-1/1 px-3">
                <label class="label" for="grid-first-name">
                  Preview Gambar
                </label>
                <div id="preview">
                  <img v-show="!newImage" :src="data.image" class="rounded w-full bg-grey flex justify-center items-center text-center bg-cover" style="height: 250px;"/>
                  <img v-show="newImage" :src="data.image" class="rounded w-full bg-grey flex justify-center items-center text-center bg-cover" style="height: 250px;"/>
                  <div v-show="data.image == null && !newImage" class="rounded w-full bg-grey flex justify-center items-center text-center" style="height: 250px;">
                    <i class="fa fa-user text-grey-light" style="font-size: 8rem !important;"/>
                  </div>
                </div>
                <input type="file" class="form-default" @change="onFileChange">
                <small class="text-grey-dark text-xs italic mt-2">Pastikan file foto kurang dari 3 mb dan berformat (jpg, jpeg, png)</small>
              </div>
            </div>
            <div class="flex flex-wrap">
              <div class="w-full md:w-1/2 px-3">
                <label class="label">
                  Nama peraih penghargaan
                </label>
                <input class="form-default" id="grid-last-name" type="text" placeholder="Irfan Maulana" v-model="data.name" @input="addEvent">
                 <p class="text-grey-dark text-xs italic mt-3">Isi nama peraih penghargaan baik siswa, guru, maupun sekolah</p>
              </div>
              <div class="w-full md:w-1/2 px-3">
                <label class="label">
                  Status 
                </label>
                <div class="relative">
                  <select class="form-default" required v-model="data.status" @input="addEvent">
                    <option value="option" disabled>Pilih status</option>
                    <option value="1">Publish</option>
                    <option value="0">Unpublish</option>
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
                <quill-editor :options="editorOption" class="bg-white" v-model="data.description" @input="addEvent"></quill-editor>
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
            <!-- Error alert -->
              <div v-if="isError && error.message.image" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ error.message.image[0] }}</div>
              <div v-if="isError && error.message.image == null" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">Ada kesalahan!! Cek kembali semua data yang anda masukkan</div>
            <!-- End Error alert -->
          </form>
        </div>
      </div>
      <!-- FORM END ADD ACHIEVEMENT -->

    </div>
  </div>
</template>

<script>
export default {
  props: ['data'],
  data() {
    return {
      isAdd: true,
      isShow: false,
      isError: false,
      isLoadingButton: false,
      error: {},
      isError: false,
      errorImage: false,
      isButtonDisable: false,
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
      newImage: false,
    }
  },
  mounted() {
    this.addEvent()
  },
  methods: {
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);

      this.newImage = true
    },
    createImage(file) {
        let reader = new FileReader();
        // let vm = this;
        reader.onload = (e) => {
            this.data.image = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      
      formData.append('file', this.file)

      axios.post('/api/update-achievement/', this.data)
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'warn',
            title: 'Oops ada kesalahan',
            text: 'Silahkan cek kembali input yang anda masukkan'
          })
          this.isError = true
          this.error = res.data.message
        } else {
          this.isLoadingButton = false
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Berhasil mengubah data'
          })
          setTimeout(() => {
            window.location.href = '/daftar-prestasi'
          }, 2000)
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Gagal mengubah data',
          text: 'Ada kesalahan sistem dan data tidak diubah'
        })
      })

    },
    cancleSubmit() {
      this.isAdd = false,
      this.isShow = true
    },
    addEvent () {
      if (this.data.title == '' || this.data.name == '') {
        this.isButtonDisable = true
      } else {
        this.isButtonDisable = false
      }
    },
  }

}
</script>
