<template>
  <div class="w-full main-blue px-32 py-16">
    <div class="flex justify-between items-start">
      <div class="flex items-center text-white" href="#">
        <img :src="'/storage/image/logo-md.png'" alt="" class="w-24 mr-4">
        <div class="text-white">
          <div class="uppercase font-semibold text-xl w-2/3">{{ title }}</div>
          <div class="mt-3 text-sm w-3/4 leading-normal">{{ address }}</div>
        </div>
      </div>
      <div class="text-white text-sm" href="#">
        <div class="mb-4">Informasi sekolah</div>
        <div class="mb-3">Kode Pos {{ phone }}</div>
        <div class="mb-3">Telp/Fax {{ fax }}</div>
        <div>Email: {{ email }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: '',
      address: '',
      phone: '',
      fax: '',
      email: '',
    }
  },
  mounted() {
    this.getInfo()
  },
  methods: {
    getInfo() {
      axios.get('/api/school-info')
      .then(res => {
        this.address = res.data.address
        this.title = res.data.title
        this.phone = res.data.phone
        this.fax = res.data.fax
        this.email = res.data.email
      })
    }
  }
}
</script>