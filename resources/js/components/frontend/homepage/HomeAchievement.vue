<template>
  <div class="flex items-stretch mb-4">
    <a :href="'/prestasi/'+achievement.slug+'/detail'" class="self-auto w-1/3 mr-10 no-underline" v-for="(achievement, index) in dataAchievement" :key="index" style="height: 380px">
      <div class="bg-white hover:shadow-md rounded">
        <div class="block mr-4 w-full object-cover bg-cover rounded-t" :style="'background-image: url('+ achievement.image +'); height: 250px;'" alt=""></div>
        <div class="p-6 text-black leading-normal text-sm">
          <div v-if="achievement.title.length > 70" class="no-underline text-black hover:text-indigo">{{ achievement.title.substr(0, 70) }}...</div>
          <div v-else class="no-underline text-black hover:text-indigo">{{ achievement.title }}</div>
          <div class="mt-2 text-grey text-xs no-underline">{{ achievement.created_at | moment("D MMM Y") }} | Admin</div>
          <div class="mt-4 font-semibold no-underline text-black">Diraih oleh : {{ achievement.name }}</div>
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dataAchievement: {}
    }
  },
  mounted() {
    this.getPrograms()
  },
  methods: {
    getPrograms() {
      axios.get('/api/homepage-achievement')
      .then(res => {
        this.dataAchievement = res.data.results
      })
      .catch(err => {
        console.log('error in data program')
      })
    }
  }
}
</script>
