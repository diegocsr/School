<template>
  <div>
    <p class="leading-loose text-grey-darker" v-if="intro.length > 450">{{ intro.substr(0,450) }}...</p>
    <p class="leading-loose text-grey-darker" v-else>{{ intro }}</p>
    <a href="#" class="no-underline mt-10 text-grey-dark inline-block btn-arrow">
      Lihat detail <img :src="'/storage/image/arrow-icon.svg'" class="inline-block w-4 ml-2" alt="">
    </a>
  </div>
</template>

<script>
export default {
  data() {
    return {
      intro: ''
    }
  },
  mounted() {
    this.getIntro()
  },
  methods: {
    getIntro() {
      axios.get('/api/homepage-intro')
      .then(res => {
        this.intro = res.data.results
      })
      .catch(err => {
        console.log(err);
      })
    }
  }
}
</script>
