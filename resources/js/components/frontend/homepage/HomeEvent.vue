<template>
  <div class="flex mb-4">
    <!-- Main event -->
    <div class="w-2/5 mr-10">
      <div class="bg-white news relative">
        <a :href="'/berita-sekolah/'+mainEvent.slug+'/detail'" class="block">
          <img v-if="!isLoading" class="block mr-4 w-full object-cover bg-cover" style="height: 350px;" :src="mainEvent.photo" alt="">
        </a>
        <div class="mt-6 text-black leading-normal">
          <a :href="'/berita-sekolah/'+mainEvent.slug+'/detail'" v-if="mainEvent.title.length > 100" class="text-base font-medium leading-normal text-black hover:text-indigo no-underline">{{ mainEvent.title.substr(0, 100) }}...</a>
          <a :href="'/berita-sekolah/'+mainEvent.slug+'/detail'" v-else class="text-base font-medium leading-normal text-black hover:text-indigo no-underline">{{ mainEvent.title }}</a>
          <div class="mt-4 text-grey text-xs">{{ mainEvent.category.name }} | {{ mainEvent.created_at | moment("D MMM YYYY") }}</div>
        </div>
      </div>
    </div>
    <!-- End main event -->

    <!-- Another event -->
    <div class="w-3/5 mr-10">
      <div class="bg-white mb-4" v-for="(item, index) in anotherEvent" :key="index">
        <div class="flex items-center">
          <a class="w-1/4" :href="'/berita-sekolah/'+item.slug+'/detail'">
            <img class="block mr-4 w-full object-cover bg-cover" style="height: 120px;" :src="item.photo_thumbnail" alt="">
          </a>
          <div class="w-3/4 pl-6">
              <a :href="'/berita-sekolah/'+item.slug+'/detail'" v-if="item.title.length > 100" class="text-base font-medium leading-normal text-black hover:text-indigo no-underline">{{ item.title.substr(0, 100) }}...</a>
              <a :href="'/berita-sekolah/'+item.slug+'/detail'" v-else class="text-base font-medium leading-normal text-black hover:text-indigo no-underline">{{ item.title }}</a>
              <div class="mt-4 text-grey text-xs">{{ item.category.name }} | {{ item.created_at | moment("D MMM YYYY") }}</div>
          </div>
        </div>
      </div>
    </div>
    <!-- End another event -->

  </div>
</template>

<script>
export default {
  data() {
    return {
      mainEvent: {
        title: '',
        slug: '',
        created_at: '',
        photo: '',
        category: {
          name: ''
        }
      },
      anotherEvent: {
        title: '',
        slug: '',
        created_at: '',
        photo_thumbnail: '',
        category: {
          name: ''
        }
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
      axios.get('/api/homepage-event')
      .then(res => {
        this.isLoading = false
        this.mainEvent = res.data.main
        this.anotherEvent = res.data.another
      })
      .catch(err => {
        console.log(err)
      })
    }
  }
}
</script>
