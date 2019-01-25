<template>
  <div class="w-full main-blue px-32 py-8">
    <ul class="list-reset flex justify-between items-center">
      <li class="">
        <a class="flex items-center text-white no-underline " href="#">
          <img :src="'/storage/image/logo-md.png'" alt="" class="w-12 mr-4">
          <div class="uppercase text-white no-underline font-semibold text-xl w-2/3">{{ title }}</div>
        </a>
      </li>
      <li style="width: 450px">
        <div class="flex items-center text-white">
          <img :src="'/storage/image/location-icon.svg'" alt="" class="w-12 mr-4">
          <div class="text-white text-xs leading-normal"><span class="text-yellow-dark uppercase font-semibold">Lokasi : </span>{{ address }}</div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: '',
      address: '',
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
      })
    }
  }
}
</script>


