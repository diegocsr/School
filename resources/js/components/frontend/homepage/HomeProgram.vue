<template>
  <div class="flex flex-wrap bg-grey-lighter">
    <div class="w-1/2 pr-10 pb-10" v-for="(program, index) in dataProgram" :key="index">
      <!-- <div class="text-grey-darker text-center bg-grey-light">1</div> -->
      <div class="flex items-center main-blue p-8 rounded">
        <img style="width: 70px" class="inline-block mr-4" :src="'storage/image/program-icon.svg'" alt="">
        <div class="text-white leading-normal text-sm">{{ program.description }}</div>
      </div>
    </div>
  </div>

  <!-- <div class="flex flex-wrap mb-4">
    <div class="w-1/2 p-8 main-blue m-6" v-for="(program, index) in dataProgram" :key="index">
      <div class="flex items-center">
        <img style="width: 70px" class="inline-block mr-4" :src="'storage/image/program-icon.svg'" alt="">
        <div class="text-white leading-normal text-sm">{{ program.description }}</div>
      </div>
    </div>
  </div> -->
</template>

<script>
export default {
  data() {
    return {
      dataProgram: {}
    }
  },
  mounted() {
    this.getPrograms()
  },
  methods: {
    getPrograms() {
      axios.get('/api/homepage-program')
      .then(res => {
        this.dataProgram = res.data.results
      })
      .catch(err => {
        console.log('error in data program')
      })
    }
  }
}
</script>
