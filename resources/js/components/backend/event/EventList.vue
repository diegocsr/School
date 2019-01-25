<template>
  <div class="container">
    <div class="w-full">
      <title-section :title="'Informasi Event'" :subtitle="'Semua informasi terkait event'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY event -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
          <div class="flex justify-between items-center mb-8">
            <div class="flex">
              <a href="/tambah-event" class="btn-indigo btn-md" title="Tambah data event">
                <i class="fa fa-plus"/>
              </a>
              <div class="relative ml-4" title="Filter kategori berita">
                <select class="form-default-inline w-48" v-model="category">
                  <option value="0" selected>Semua status</option>
                  <option v-for="(data, index) in dataCategory" :value="data.id" :key="index">{{ data.name }}</option> 
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
              </div>
            </div>
            <div>
              <input type="text" v-model="search" class="form-default-inline btn-md" placeholder="Cari judul berita...">
            </div>
          </div>
          <table class="w-full block">
            <thead>
              <tr>
                <th>No.</th>
                <th width="300">Judul</th>
                <th width="120">Kategori</th>
                <th width="120">Status</th>
                <th width="120">Tgl Dibuat</th>
                <th width="120">Tgl Diubah</th>
                <th width="160" align="center">Pilihan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="isLoading">
                <td v-for="n in 7" :key="n"><text-loading></text-loading></td>
              </tr>
              <tr v-if="!isLoading && events.length > 0 && filterEvent.length > 0" v-for="(item, index) in filterEvent" :key="index">
                <td>{{ index+1 }}</td>
                <td v-if="item.title.length > 70">{{ item.title.substr(0, 70) }}...</td>
                <td v-else>{{ item.title }}</td>
                <td>{{ item.category.name }}</td>
                <td v-if="item.status"><span class="btn-green btn-sm">Published</span></td>
                <td v-if="!item.status"><span class="btn-grey btn-sm">Unpublished</span></td>
                <td>{{ item.created_at | moment("D/M/YY") }}</td>
                <td>{{ item.updated_at | moment("D/M/YY") }}</td>
                <td v-if="isLoadingButton"><span class="btn-grey btn-sm"><spinner></spinner></span></td>
                <td v-if="!isLoadingButton">
                  <a v-if="item.status == false" href="#" @click.prevent="publishEvent(item.id)" class="btn-green btn-sm" title="Publish event">
                    <i class="fa fa-upload"></i>
                  </a>
                  <a v-else href="#" @click.prevent="unpublishEvent(item.id)" class="btn-grey btn-sm" title="Unpublih event">
                    <i class="fa fa-download"></i>
                  </a>
                  <a :href="'/event/'+ item.slug +'/detail'" class="btn-orange btn-sm" title="Lihat preview event">
                    <i class="fa fa-eye"></i>
                  </a>
                  <a :href="'/ubah-event/'+ item.slug" class="btn-blue btn-sm" title="Edit data event">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="#" @click.prevent="deleteData(item.id)" class="btn-red btn-sm" title="Hapus data event">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <tr v-if="!isLoading && filterEvent.length < 1">
                <td colspan="6" align="center">Data event tidak dapat ditemukan</td>
              </tr>
            </tbody>
          </table>
          <div class="flex justify-between items-center mt-8">
            <div class="btn-grey btn-md cursor-pointer">
              <i class="fa fa-chevron-left"/> 
              Previous
            </div>
            <div class="font-semibold">
              Total : {{filterEvent.length}}
            </div>
            <div class="btn-grey btn-md cursor-pointer">
              Next
              <i class="fa fa-chevron-right"/> 
            </div>
          </div>
        </div>
      </div>
      <!-- END DISPLAY event -->

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      events: false,
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      isError: false,
      errorImage: '',
      error: {
        name: [],
        nip: [],
        category: [],
        status: []
      },
      errorAll: '',
      dataCategory: {},
      new_data: {},
      edit_data: {},
      image: false,
      selected: 'bar',
      search: '',
      category: 0
    }
  },
  computed: {
    filterEvent() {
      var pos = this.category
      if (pos > 0) {
        return [...this.events].filter(item => {
          if (this.search) {
            return (item.title.toLowerCase().includes(this.search.toLowerCase()))
          } 
          return (item.category_id == pos)
        })
      } else {
        return [...this.events].filter(item => {
          return (item.title.toLowerCase().includes(this.search.toLowerCase()))
        })
      }
    }
  },
  mounted() {
    this.getEvents()
  },
  methods: {
    getEvents() {
      this.isLoading = true
      axios.get('/api/event')
      .then(res => {
        this.isLoading = false
        this.events = res.data.results
        this.dataCategory = res.data.data_category
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          duration: -1000,
          title: 'Ada kesalahan sistem',
          text: 'Data event tidak dapat ditampilkan'
        })
      })
    },
    publishEvent(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi perubahan status',
        text: 'Apakah anda ingin mengubah status publikasi dari prestasi ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => {
              axios.post('/api/publish-event/'+id)
              .then(res => {
                this.isLoadingButton = false
                this.$notify({
                  group: 'notif',
                  position: 'top right',
                  type: 'success',
                  title: 'Sukses',
                  text: 'Event berhasil dipublish'
                })
                this.getEvents()
                this.$modal.hide('dialog')
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
                this.getEvents()
                this.$modal.hide('dialog')
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
    unpublishEvent(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi perubahan status',
        text: 'Apakah anda ingin mengubah status publikasi dari prestasi ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => {
              axios.post('/api/unpublish-event/'+id)
              .then(res => {
                this.isLoadingButton = false
                this.$modal.hide('dialog')
                this.$notify({
                  group: 'notif',
                  position: 'top right',
                  type: 'success',
                  title: 'Sukses',
                  text: 'Event berhasil diunpublish'
                })
                this.getEvents()
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
                this.getEvents()
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
    deleteData(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus data prestasi ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/delete-event/'+id)
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
    }

  }
}
</script>

<style scoped>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  width: 100%;
  max-height: 250px;
  background: #f1f5f8;
  object-fit: cover;
  border-radius: 10px;
}
</style>
