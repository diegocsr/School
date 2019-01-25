<template>
  <div class="container w-3/4">
    <div class="w-full">
      <div class="flex items-center justify-between">
        <title-section :title="'Informasi Profil Sekolah'" :subtitle="'Semua informasi terkait informasi sekolah'"></title-section>

        <!-- NOTIFICATION -->
        <notifications group="notif" />
        <!-- END NOTIFICATION -->
        
        <div class="">
          <a v-if="isEdit == false" href="#" @click.prevent="showEditor()" class="btn-md btn-indigo mt-4 inline-block">Edit</a>
          <a v-if="isEdit == true" href="#" @click.prevent="closeEditor()" class="btn-md btn-grey mt-4 inline-block">Batal</a>
          <a v-if="isLoadingButton == false && isEdit == true" href="#" @click.prevent="updateProfile()" class="btn-md btn-indigo mt-4 inline-block">Perbarui Data</a>
          <a v-if="isLoadingButton == true" href="#" class="btn-md btn-indigo mt-4 inline-block"><spinner></spinner></a>
        </div>
      </div>
    </div>
    
    <div class="flex w-full align-middle items-center">
      <div class="w-full border border-grey-light p-8 bg-white rounded">
        <paragraph-loading v-if="isEdit == false && isLoading == true"></paragraph-loading>
        <div v-if="isEdit == false && isLoading == false" class="editor">
          <div class="cursor-pointer" title="Klik untuk mengedit isi konten" v-if="profile.body !== null" v-html="profile.body" @click.prevent="showEditor()"></div>
          <div v-else>Profil sekolah kosong</div>
        </div>
        <quill-editor v-if="isEdit == true" v-model="profile.body" :options="editorOption" class="bg-white"></quill-editor>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      profile: false,
      isEdit: false,
      content: {
        body: ''
      },
      isLoading: false,
      isLoadingButton: false,
      data_edit: '',
      editorOption: {
        placeholder: 'Whats in your mind',
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
      }
    }
  },
  mounted() {
    this.getProfile()
  },
  methods: {
    getProfile() {
      this.isLoading = true
      axios.get('/api/profile')
      .then(res => {
        this.isLoading = false
        this.profile = res.data.results
      })
      .catch(err => {

      })
    },
    showEditor() {
      this.isEdit = true
    },
    closeEditor() {
      this.isEdit = false
      this.getProfile()
    },
    updateProfile() {
      this.isLoadingButton = true
      axios.post('/api/update-profile/', this.profile)
      .then(res => {
        this.isLoadingButton = false
        this.data_edit = {}
        this.isEdit = false
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'success',
          title: 'Sukses',
          text: 'Profil sekolah berhasil diperbarui'
        })
        this.getProfile()
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Profil sekolah tidak diperbarui'
        })
        this.isLoadingButton = false
      })
    },
    submitProfile() {
      this.isLoadingButton = true
      axios.post('/api/submit-profile', this.new_content)
      .then(res => {
        if (res.data.status) {
          this.isLoadingButton = false
          this.new_content = ''
          alert(res.data.message)
          this.getProfile()
        }
      })
      .catch(err => {
        alert('Oops ada masalah')
      })
    }
  }
}
</script>

