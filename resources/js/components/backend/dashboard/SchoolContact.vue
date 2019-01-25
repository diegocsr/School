<template>
  <div class="w-2/5">

    <!-- NOTIFICATION -->
    <notifications group="notif" />
    <!-- END NOTIFICATION -->

    <div class="text-xl text-grey-darker font-medium m-2 mb-6 mt-8">
      <i class="fa fa-info-circle stroke-current text-grey"></i>
      Kontak sekolah
    </div>
    <div v-if="isEdit == false" class="flex w-full align-middle items-center">
      <div class="w-full border border-grey-light p-8 bg-white rounded m-2">
        <small class="label">Nama sekolah</small>
        <text-loading v-if="isLoading"></text-loading>
        <div v-else class="mb-3 text-base font-normal">{{ contact.name }}</div>
        <small class="label">Alamat sekolah</small>
        <text-loading v-if="isLoading"></text-loading>
        <div v-else class="mb-3 text-base font-normal leading-normal">{{ contact.address }}</div>
        <small class="label">Nomor telepon</small>
        <text-loading v-if="isLoading"></text-loading>
        <div v-else class="mb-3 text-base font-normal">{{ contact.phone }}</div>
        <small class="label">Status akreditasi</small>
        <text-loading v-if="isLoading"></text-loading>
        <div v-else class="mb-3 text-base font-normal">Terakreditasi {{ contact.accreditation }}</div>
        <small class="label">Alamat email</small>
        <text-loading v-if="isLoading"></text-loading>
        <div v-else class="mb-3 text-base font-normal">{{ contact.email }}</div>
        <a href="#" @click.prevent="editContact(contact.id)" class="btn-md btn-indigo mt-4 inline-block">Perbarui</a>
      </div>
    </div>

    <div v-if="isEdit == true" class="flex w-full align-middle items-center">
      <div class="w-full border border-grey-light p-8 bg-white rounded m-2">
        <small class="label">Nama sekolah</small>
        <div class="mb-3 mt-1 text-base font-normal">
          <input class="form-default" type="text" v-model="data_edit.name">
        </div>
        <small class="label">Alamat sekolah</small>
          <textarea class="form-default" type="text" style="height: 120px;" v-model="data_edit.address"/>
        <small class="label">Nomor telepon</small>
          <input class="form-default" type="text" v-model="data_edit.phone">
        <small class="label">Status akreditasi</small>
          <!-- <input class="form-default" type="text" v-model="data_edit.accreditation"> -->
          <div class="relative">
            <select class="form-default">
              <option>A</option>
              <option>B</option>
              <option>C</option>
            </select>
            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
              <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
          </div>
        <small class="label">Alamat email</small>
          <input class="form-default" type="text" v-model="data_edit.email">
        <small class="label">Nomor fax</small>
          <input class="form-default" type="text" v-model="data_edit.fax">
        <small class="label">NISN</small>
          <input class="form-default" type="text" v-model="data_edit.nisn">
        <button @click.prevent="clear()" :class="isLoadingButton == true ? 'btn-md btn-grey mt-4 inline-block cursor-not-allowed' : 'btn-md btn-grey mt-4 inline-block'">Batal</button>
        <button v-if="isLoadingButton == false" @click.prevent="updateContact()" class="btn-md btn-indigo mt-4 inline-block">Simpan</button>
        <button v-if="isLoadingButton == true" class="btn-md btn-indigo mt-4 inline-block"><spinner></spinner></button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      contact: {},
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      data_edit: {}
    }
  },
  computed: { },
  mounted() {
    this.getContact()
  },
  methods: {
    getContact() {
      this.isLoading = true
      axios.get('/api/contact')
      .then(res => {
        this.isLoading = false
        this.contact = res.data.results
      })
      .catch(err => {
        alert(err)
      })
    },
    editContact(id) {
      this.isEdit = true
      this.data_edit = this.contact
    },
    updateContact() {
      this.isLoadingButton = true
      axios.post('/api/contact-update/', this.data_edit)
      .then(res => {
        this.isLoadingButton = false
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'success',
          title: 'Sukses',
          text: 'Kontak sekolah berhasil diperbarui'
        })
        this.data_edit = {}
        this.isEdit = false
        this.getContact()
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Kontak sekolah tidak diperbarui'
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
