<template>
  <div class="w-3/5">
    <div class="text-xl text-grey-darker font-medium m-2 mb-6 mt-8">
      <i class="fa fa-info-circle stroke-current text-grey"></i>
      Informasi sekolah
    </div>
    <div class="flex w-full align-middle items-center">
      <div class="w-full border border-grey-light p-8 bg-white rounded m-2">
        <div class="flex items-center justify-between">
          <div>
            <small class="font-semibold text-grey-dark mb-2">Link pendaftaran</small>
            <div class="mb-3 mt-1 text-base font-normal">Status link pendaftaran siswa baru <span class="font-bold text-base">Tidak aktif</span></div>
          </div>
          <a href="#" class="btn-md btn-indigo mt-4 inline-block">Aktifkan</a>
        </div>
        <div class="border-b border-grey-light w-full block my-5"></div>
        <div class="flex items-center justify-between">
          <div>
            <small class="font-semibold text-grey-dark mb-2">Link jadwal akademik</small>
            <div class="mb-3 mt-1 text-base font-normal">Status link pendaftaran siswa baru <span class="font-bold text-base">Tidak aktif</span></div>
          </div>
          <a href="#" class="btn-md btn-indigo mt-4 inline-block">Aktifkan</a>
        </div>
      </div>
    </div>

    <div class="text-xl text-grey-darker font-medium m-2 mb-6 mt-8">
      <i class="fa fa-info-circle stroke-current text-grey"></i>
      Pengantar sekolah
    </div>
    <div v-if="isEdit == false" class="flex w-full align-middle items-center">
      <div class="w-full border border-grey-light p-8 bg-white rounded m-2">
        <div v-if="isLoading"><text-loading></text-loading></div>
        <div v-else class="block leading-normal text-base">{{ intro }}</div>
        <a href="#" @click.prevent="editIntro(intro)" class="btn-md btn-indigo mt-4 inline-block">Perbarui</a>
      </div>
    </div>
    <div v-if="isEdit == true" class="flex w-full align-middle items-center">
    <div class="w-full border border-grey-light p-8 bg-white rounded m-2">
      <small class="label">Pengantar sekolah</small>
      <div class="mb-3 mt-1 text-base font-normal">
        <textarea class="form-default" type="text" v-model="data_edit.intro" style="height: 200px;">
        </textarea>
      </div>
      <button @click.prevent="clear()" :class="isLoadingButton == true ? 'btn-md btn-grey mt-4 inline-block cursor-not-allowed' : 'btn-md btn-grey mt-4 inline-block'">Batal</button>
      <button v-if="isLoadingButton == false" @click.prevent="updateIntro()" class="btn-md btn-indigo mt-4 inline-block">Simpan</button>
      <button v-if="isLoadingButton == true" class="btn-md btn-indigo mt-4 inline-block"><spinner></spinner></button>
    </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      intro: null,
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      data_edit: {
        intro: null
      }
    }
  },
  mounted() {
    this.getIntro()
  },
  methods: {
    getIntro() {
      this.isLoading = true
      axios.get('/api/intro')
      .then(res => {
        this.isLoading = false
        this.intro = res.data.results.body
      })
      .catch(err => {
        alert(err)
      })
    },
    editIntro(intro) {
      this.isEdit = true
      this.data_edit.intro = intro
    },
    updateIntro() {
      this.isLoadingButton = true
      axios.post('/api/intro-update/', this.data_edit)
      .then(res => {
        this.isLoadingButton = false
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'success',
          title: 'Sukses',
          text: 'Pengantar sekolah berhasil diperbarui'
        })
        this.data_edit = {}
        this.isEdit = false
        this.getIntro()
      })
      .catch(err => {
        this.isLoadingButton = false
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Pengantar sekolah tidak diperbarui'
        })
      })
    },
    clear() {
      this.data_edit = {}
      this.isEdit = false
    }
  }
}
</script>
