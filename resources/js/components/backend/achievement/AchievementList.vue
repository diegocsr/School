<template>
  <div class="container">
    <div class="w-full">
      <title-section :title="'Informasi Prestasi Sekolah'" :subtitle="'Semua informasi terkait prestasi guru, murid dan sekolah'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY ACHIEVEMENT -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
          <div class="flex justify-between items-center mb-8">
            <div class="flex">
              <a href="/tambah-prestasi" class="btn-indigo btn-md" title="Tambah prestasi">
                <i class="fa fa-plus"/>
              </a>
              <div class="relative ml-4" title="Filter status">
                <select class="form-default-inline w-48" v-model="status">
                  <option value="all" selected>Semua status</option>
                  <option value="1">Publish</option>
                  <option value="0">Unpublish</option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
              </div>
            </div>
            <div class="form-default-inline btn-md text-base">Total prestasi : {{ filterAchievement.length }}</div>
          </div>

          <card-horizontal-loading v-if="isLoading"></card-horizontal-loading>
          
          <div class="flex flex-wrap items-stretch justify-between content-start">         
            <div v-if="!isLoading && filterAchievement.length > 0" v-for="(item, index) in filterAchievement" :key="index" :id="index" class="max-w-md w-1/2 lg:flex mb-4 cursor-pointer relative card px-2">
              
              <div class="absolute w-full h-32 rounded card-hover pin-l z-10" style="width: 96.5%; left: 8px;">
                <div class="m-auto w-3/3 text-center" style="top: 35%; position: relative">
                  
                  <spinner v-if="isLoadingButton" style="position: relative; top: 15px;"></spinner>

                  <a v-if="!isLoadingButton && item.status == false" href="#" @click.prevent="publishAchievement(item.id)" title="Publish data ke web">
                    <i class="fa fa-arrow-up btn-round bg-orange hover:bg-orange-dark"/>
                  </a>
                  <a v-if="!isLoadingButton && item.status == true" href="#" @click.prevent="unpublishAchievement(item.id)" title="Unpublish data dari web">
                    <i class="fa fa-arrow-down btn-round bg-grey hover:bg-grey-dark"/>
                  </a>
                  <a v-if="!isLoadingButton" :href="'/ubah-prestasi/'+item.slug" title="Edit data prestasi">
                    <i class="fa fa-edit btn-round bg-green hover:bg-green-dark"/>
                  </a>
                  <a v-if="!isLoadingButton" href="#" @click.prevent="openModalShow(item)" title="Lihat detail prestasi">
                    <i class="fa fa-eye btn-round bg-indigo hover:bg-indigo-dark"/>
                  </a>
                  <a v-if="!isLoadingButton" href="#" @click.prevent="deleteAchievement(item.id)" title="Hapus data prestasi">
                    <i class="fa fa-trash btn-round bg-red hover:bg-red-dark"/>
                  </a>
                </div>
              </div>

              <div class="h-32 lg:w-32 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" :style="'background-image: url('+item.image_thumbnail+');'" :title="item.title">
              </div>
              <div class="card-horizontal lg:border-l-0 lg:border-t lg:border-grey-light lg:rounded-b-none lg:rounded-r w-full p-6">
                <div class="relative">
                  <div class="text-black font-bold text-xl mb-2" v-if="item.title.length > 44">{{ item.title.substr(0, 44) }}...</div>
                  <div class="text-black font-bold text-xl mb-2" v-if="item.title.length < 44">{{ item.title }}</div>
                  <p class="text-base text-grey-darker">{{ item.name }}</p>
                </div>
              </div>
            </div>
            <div v-if="!isLoading && filterAchievement.length == 0" class="w-full text-center py-24">
              <spinner-grey class="opacity-50"></spinner-grey>
              <div class="text-2xl text-grey text-center mt-8">Data prestasi tidak dapat ditemukan</div> 
            </div>
          </div>
        </div>
      </div>
      <!-- END DISPLAY ACHIEVEMENT -->

    </div> 
  </div>
</template>

<script>
export default {
  data() {
    return {
      achievements: {},
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      isError: false,
      status: 'all',
      show: {}
    }
  },
  mounted() {
    this.getAchievements()
  },
  computed: {
    filterAchievement() {
      if (this.status == 'all') {
        return this.achievements
      } else {
        return [...this.achievements].filter(item => {
          return (item.status == this.status)
        })
      }
    }
  },
  methods: {
    getAchievements() {
      this.isLoading = true
      axios.get('/api/achievement')
      .then(res => {
        this.isLoading = false
        this.achievements = res.data.results
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          duration: -1000,
          title: 'Ada kesalahan sistem',
          text: 'Data prestasi tidak dapat ditampilkan'
        })
      })
    },
    publishAchievement(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi perubahan status',
        text: 'Apakah anda ingin mengubah status publikasi dari prestasi ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/publish-achievement/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Prestasi berhasil dipublish'
                  });
                  this.getAchievements()
                })
                .catch(err => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'error',
                    title: 'Oops ada kesalahan',
                    text: 'Ada kesalahan pada aksi ini'
                  });
                  this.getAchievements()
                })
            }
          },
          {
            title: '❌ Batal',
            handler: () => {
              this.isLoadingButton = false
              this.$notify({
                group: 'notif',
                position: 'top right',
                type: 'warn',
                title: 'Perintah dibatalkan'
              });
              this.$modal.hide('dialog')
             }
          }
        ],
        escapeToClose: false
      })
    },
    unpublishAchievement(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi perubahan status',
        text: 'Apakah anda ingin mengubah status publikasi dari prestasi ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/unpublish-achievement/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Prestasi berhasil diunpublish'
                  });
                  this.getAchievements()
                })
                .catch(err => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'error',
                    title: 'Oops ada kesalahan',
                    text: 'Ada kesalahan pada aksi ini'
                  });
                  this.getAchievements()
                })
            }
          },
          {
            title: '❌ Batal',
            handler: () => {
              this.isLoadingButton = false
              this.$notify({
                group: 'notif',
                position: 'top right',
                type: 'warn',
                title: 'Perintah dibatalkan'
              });
              this.$modal.hide('dialog')
             }
          }
        ],
        escapeToClose: false
      })
    },
    deleteAchievement(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus data prestasi ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/delete-achievement/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Prestasi berhasil dihapus'
                  });
                  this.getAchievements()
                })
                .catch(err => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'error',
                    title: 'Oops ada kesalahan',
                    text: 'Ada kesalahan pada aksi ini'
                  });
                  this.getAchievements()
                })
            }
          },
          {
            title: '❌ Batal',
            handler: () => {
              this.isLoadingButton = false
              this.$modal.hide('dialog')
              this.$notify({
                group: 'notif',
                position: 'top right',
                type: 'warn',
                title: 'Perintah dibatalkan'
              });
             }
          }
        ],
        escapeToClose: false
      })
    },
    openModalShow(item) {
      this.$modal.show('show-data')
      this.show = item
    }
  }
}
</script>
