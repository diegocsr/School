<template>
<div class="w-full">

  <!-- NOTIFICATION -->
  <notifications group="notif" />
  <!-- END NOTIFICATION -->

  <div class="text-xl text-grey-darker font-medium m-2 mb-4">
    <i class="fa fa-info-circle stroke-current text-grey"></i>
    Beranda admin panel
  </div>
  <div class="flex">
    <a href="/daftar-prestasi" class="flex-1 text-left bg-indigo px-4 py-4 m-2 rounded relative no-underline hover:bg-indigo-light">
      <div class="w-full mb-3 text-white">
        <div class="flex justify-between">
          <div class="text-white">Daftar prestasi</div>
          <div class="block relative"><i class="fa fa-trophy w-full fa-dashboard"></i></div>
        </div>
      </div>
      <div v-if="isLoading" class="text-white text-4xl font-semibold"><spinner></spinner></div>
      <div v-else class="text-white text-4xl font-semibold">{{ totalAchievements }}</div>

    </a>
    <a href="/event-sekolah" class="flex-1 text-left bg-green px-4 py-4 m-2 rounded relative no-underline hover:bg-green-light">
      <div class="w-full mb-3 text-white">
        <div class="flex justify-between">
          <div class="text-white">Daftar berita</div>
          <div class="block relative"><i class="fa fa-newspaper-o w-full fa-dashboard"></i></div>
        </div>
      </div>
      <div v-if="isLoading" class="text-white text-4xl font-semibold"><spinner></spinner></div>
      <div v-else class="text-white text-4xl font-semibold">{{ totalEvents }}</div>
    </a>
    <a href="/daftar-guru" class="flex-1 text-left bg-orange px-4 py-4 m-2 rounded relative no-underline hover:bg-orange-light">
      <div class="w-full mb-3 text-white">
        <div class="flex justify-between">
          <div class="text-white">Daftar guru</div>
          <div class="block relative"><i class="fa fa-bars w-full fa-dashboard"></i></div>
        </div>
      </div>
      <div v-if="isLoading" class="text-white text-4xl font-semibold"><spinner></spinner></div>
      <div v-else class="text-white text-4xl font-semibold">{{ totalTeachers }}</div>
    </a>
    <a href="/program-sekolah" class="flex-1 text-left bg-red px-4 py-4 m-2 rounded relative no-underline hover:bg-red-light">
      <div class="w-full mb-3 text-white">
        <div class="flex justify-between">
          <div class="text-white">Program sekolah</div>
          <div class="block relative"><i class="fa fa-table w-full fa-dashboard"></i></div>
        </div>
      </div>
      <div v-if="isLoading" class="text-white text-4xl font-semibold"><spinner></spinner></div>
      <div v-else class="text-white text-4xl font-semibold">{{ totalPrograms }}</div>
    </a>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      isLoading: false,
      totalAchievements: null,
      totalEvents: null,
      totalTeachers: null,
      totalPrograms: null
    }
  },
  mounted() {
    this.getTotal()
  },
  methods: {
    getTotal() {
      this.isLoading = true
      axios.get('/api/total-info')
      .then(res => {
        this.isLoading = false
        this.totalAchievements = res.data.achievements
        this.totalEvents = res.data.events
        this.totalTeachers = res.data.teachers
        this.totalPrograms = res.data.programs
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Ada kesalahan pada sistem',
          text: 'Info tidak dapat ditampilkan'
        })
      })
    }
  }
}
</script>
