<template>
  <section class="w-100 relative">
    <img class="object-cover" style="height: 600px; width: 100%;" :src="header.photo" alt="">
    <div class="text-white absolute" style="bottom: 240px; left: 130px;">
      <div class="text-4xl font-semibold w-4/5">{{ header.title }}</div>
      <div class="mt-6 mb-10">{{ header.category.name }} | {{ header.created_at | moment("D MMM YYYY") }}</div>
      <div class="block">
        <a :href="'/berita-sekolah/'+header.slug+'/detail'" class="px-4 py-2 bg-white text-black no-underline mt-6 text-sm hover:bg-grey-light">Lihat Detail</a>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      header: {
        title: null,
        slug: null,
        category: {
          name: null
        },
        created_at: null
      },
      isLoading: false
    }
  },
  mounted() {
    this.getEvents()
  },
  methods: {
    getEvents() {
      this.isLoading = true
      axios.get('/api/homepage-header')
      .then(res => {
        this.isLoading = false
        this.header = res.data.results
      })
      .catch(err => {
        console.log(err)
      })
    }
  }
}
</script>


