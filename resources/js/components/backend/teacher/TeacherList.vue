<template>
  <div class="container">
    <div class="w-full">
      <progress v-if="uploadPercentage > 0" max="100" :value.prop="uploadPercentage" class="w-full"></progress>
      <title-section :title="'Informasi Guru dan Karyawan'" :subtitle="'Semua informasi terkait guru dan karyawan'"></title-section>

      <!-- NOTIFICATION AND DIALOG -->
      <notifications group="notif" />
      <v-dialog :clickToClose="false"/>
      <!-- END NOTIFICATION AND DIALOG -->

      <!-- DISPLAY TEACHER -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
          <div class="flex justify-between items-center mb-8">
            <div class="flex">
              <a href="#" @click.prevent="addTeacher()" class="btn-indigo btn-md" title="Tambah data guru">
                <i class="fa fa-plus"/>
              </a>
              <div class="relative ml-4" title="Filter jabatan">
                <select class="form-default-inline w-48" v-model="position">
                  <option value="0" selected>Semua posisi</option>
                  <option v-for="(data, index) in dataPosition" :value="data.id" :key="index">{{ data.position }}</option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
              </div>
            </div>
            <div>
              <input type="text" v-model="search" class="form-default-inline btn-md" placeholder="Cari nama guru...">
            </div>
          </div>
          <table class="w-full block">
            <thead>
              <tr>
                <th width="75">Foto</th>
                <th width="300">Nama</th>
                <th width="250">Nip</th>
                <th>Jabatan</th>
                <th>Mata Pelajaran</th>
                <th width="50">Pilihan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="isLoading">
                <td v-for="n in 6" :key="n"><text-loading></text-loading></td>
              </tr>
              <tr v-if="!isLoading && teachers.length > 0 && filterTeacher.length > 0" v-for="(item, index) in filterTeacher" :key="index">
                <td>
                  <img v-if="item.photo && item.photo_thumbnail" class="rounded-full h-12 w-12 object-cover appearance-none" :src="item.photo_thumbnail" alt="" :title="item.name">
                  <img v-else class="rounded-full h-12 w-12 object-cover" :src="'/uploads/teachers/defaults/default-avatar-min.jpg'" alt="">
                </td>
                <td>{{ item.name }}</td>
                <td>{{ item.nip }}</td>
                <td>{{ item.position.position }}</td>
                <td>{{ item.course }}</td>
                <td>
                  <!-- <a href="#" @click.prevent="detailTeacher(item.id)" class="btn-green btn-sm">
                    <i class="fa fa-eye"></i>
                  </a> -->
                  <a href="#" @click.prevent="openModalEdit(item)" class="btn-blue btn-sm" title="Edit data guru">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="#" @click.prevent="deleteData(item.id)" class="btn-red btn-sm" title="Hapus data guru">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
              <tr v-if="!isLoading && teachers.length == 0">
                <td colspan="6" align="center">Data guru kosong</td>
              </tr>
              <tr v-if="!isLoading && filterTeacher.length < 1">
                <td colspan="6" align="center">Data guru tidak dapat ditemukan</td>
              </tr>
            </tbody>
          </table>
          <div class="flex justify-between items-center mt-8">
            <div class="btn-grey btn-md cursor-pointer">
              <i class="fa fa-chevron-left"/> 
              Previous
            </div>
            <div class="font-semibold">
              Total : {{filterTeacher.length}}
            </div>
            <div class="btn-grey btn-md cursor-pointer">
              Next
              <i class="fa fa-chevron-right"/> 
            </div>
          </div>
        </div>
      </div>
      <!-- END DISPLAY TEACHER -->

      <!-- MODAL CREATE -->
      <modal name="add-teacher" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah data guru</div>
          <div class="flex">
            <div class="w-1/2">
              <small class="label">Nama</small>
              <input :class="isError && error.name ? 'form-default-error' : 'form-default'" type="text" v-model="new_data.name" required>
              <div v-if="isError && error.name" class="text-sm py-2 block text-red">{{ error.name[0] }}</div>

              <small class="label">NIP</small>
              <input :class="isError && error.nip ? 'form-default-error' : 'form-default'" type="number" v-model="new_data.nip" required>
              <div v-if="isError && error.nip" class="text-sm py-2 block text-red">{{ error.nip[0] }}</div>

              <small class="label">Jabatan</small>
              <div class="relative">
                <select :class="isError && error.position ? 'form-default-error' : 'form-default'" v-model="new_data.position" required>
                  <option v-for="(data, index) in dataPosition" :value="data.id" :key="index">{{ data.position }}</option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
              </div>
              <div v-if="isError && error.position" class="text-sm py-2 block text-red">{{ error.position[0] }}</div>

              <small class="label">Mata Pelajaran</small>
              <input :class="isError && error.course ? 'form-default-error' : 'form-default'" type="text" v-model="new_data.course" required>
              <div v-if="isError && error.course" class="text-sm py-2 block text-red">{{ error.course[0] }}</div>

              <div class="w-full mt-8 block">
                <button v-if="!isLoadingButton" @click="clearData('add')" class="btn-grey btn-md">
                <i class="fa fa-close"/> Batal</button>
                <button v-if="!isLoadingButton" @click="submitData()" class="btn-indigo btn-md">
                <i class="fa fa-save"/> Simpan</button>
                <a v-if="isLoadingButton" href="#" class="btn-indigo btn-md"><spinner></spinner></a>
              </div>
            </div>
            <div class="w-1/2 pl-8">
              <small class="label">Preview Foto</small>
              <div id="preview">
                <img v-if="image" :src="image" class="appearance-none"/>
                <div v-else class="rounded w-full bg-grey flex justify-center items-center text-center" style="height: 250px;">
                  <i class="fa fa-user text-grey-light" style="font-size: 8rem !important;"/>
                </div>
              </div>
              <small class="label">Foto</small>
              <input type="file" class="form-default" @change="onFileChange">
              <small class="text-grey-dark text-xs italic mt-2">Pastikan file foto kurang dari 3 mb dan berformat (jpg, jpeg, png)</small>
              <!-- Error alert -->
              <div v-if="isError && errorImage" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ errorImage }}</div>
              <div v-if="isError && errorAll.length > 0" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ errorAll }}</div>
              <!-- End Error alert -->
            </div>
          </div>
        </div>
      </modal>
      <!-- END MODAL CREATE -->

      <!-- MODAL EDIT -->
      <modal name="edit-teacher" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Ubah data guru</div>
          <div class="flex">
            <div class="w-1/2">
              <small class="label">Nama</small>
              <input class="form-default" type="text" v-model="edit_data.name" required>
              <small class="label">NIP</small>
              <input class="form-default" type="text" v-model="edit_data.nip" required>
              <small class="label">Jabatan</small>
              <div class="relative">
                <select class="form-default" v-if="isEdit" v-model="edit_data.position.id" required>
                  <option v-for="(data, index) in dataPosition" :selected="edit_data.position ? true : false" :value="data.id" :key="index">{{ data.position }}</option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
              </div>
              <small class="label">Mata Pelajaran</small>
              <input class="form-default" type="text" v-model="edit_data.course" required>
              <div class="w-full mt-8 block">
                <button v-if="!isLoadingButton" href="#" @click="clearData('edit')" class="btn-grey btn-md">
                <i class="fa fa-close"/> Batal</button>
                <button v-if="!isLoadingButton" href="#" @click="updateData()" class="btn-indigo btn-md">
                <i class="fa fa-save"/> Simpan</button>
                <a v-if="isLoadingButton" href="#" class="btn-indigo btn-md"><spinner></spinner></a>
              </div>
            </div>
            <div class="w-1/2 pl-8">
              <small class="label">Preview Foto</small>
              <div id="preview">
                <img v-if="image" :src="image" class="appearance-none"/>
                <img v-if="!image && edit_data.photo" :src="edit_data.photo" class="appearance-none" :title="edit_data.name"/>
                <div v-if="!image && !edit_data.photo" class="rounded w-full bg-grey flex justify-center items-center text-center appearance-none" style="height: 250px;">
                  <i class="fa fa-user text-grey-light" style="font-size: 8rem !important;"/>
                </div>
              </div>
              <small class="label">Foto</small>
              <input type="file" class="form-default" @change="onFileChange">
              <small class="text-grey-dark text-xs italic mt-2">Pastikan file foto kurang dari 3 mb dan berformat (jpg, jpeg, png)</small>
              <!-- Error alert -->
              <div v-if="isError" class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ error.message }}</div>
              <!-- End Error alert -->
            </div>
          </div>
        </div>
      </modal>
      <!-- END MODAL EDIT -->

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      teachers: false,
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      isError: false,
      errorImage: '',
      error: {
        name: [],
        nip: [],
        position: [],
        course: []
      },
      errorAll: '',
      dataPosition: {},
      new_data: {},
      uploadPercentage: 0,
      edit_data: {},
      image: false,
      selected: 'bar',
      search: '',
      position: 0
    }
  },
  computed: {
    filterTeacher() {
      var pos = this.position
      if (pos > 0) {
        return [...this.teachers].filter(item => {
          if (this.search) {
            return (item.name.toLowerCase().includes(this.search.toLowerCase()))
          } 
          return (item.position_id == pos)
        })
      } else {
        return [...this.teachers].filter(item => {
          return (item.name.toLowerCase().includes(this.search.toLowerCase()))
        })
      }
    }
  },
  mounted() {
    this.getTeachers()
  },
  methods: {
    getTeachers() {
      this.isLoading = true
      axios.get('/api/teacher')
      .then(res => {
        this.isLoading = false
        this.teachers = res.data.results
        this.dataPosition = res.data.data_position
      })
      .catch(err => {
        this.dataPosition = err.data.data_position
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Oops ada kesalahan',
          text: 'Data guru tidak dapat ditampilkan'
        })
      })
    },
    addTeacher() {
      this.$modal.show('add-teacher')
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;
      this.createImage(files[0]);
    },
    createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
            vm.image = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      
      formData.append('file', this.file)

      axios.post('/api/submit-teacher/', {'image': this.image, 'data': this.new_data}, {
        onUploadProgress: function( progressEvent ) {
          this.uploadPercentage = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) )
        }.bind(this)
      })
      .then(res => {
        if (res.data.error == 'validation' || res.data.error == 'validation-both') {
          this.isLoadingButton = false
          if (res.data.error == 'validation') {

            if (res.data.info == 'image') {
              this.isError = true
              this.errorImage = 'Format file tidak sesuai'
            }

            if (res.data.info == 'data') {
              this.isError = true
              this.error = res.data.message
            }

          } else {
            this.isError = true
            this.errorAll = 'Error, Silahkan cek semua data yang dimasukkan'
          }
        } else {
          this.isLoadingButton = false
          this.$modal.hide('add-teacher')
          this.new_data = {}
          this.image = false
          this.error = {}
          this.isError = false
          this.errorImage = false
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'success',
            title: 'Sukses',
            text: 'Data berhasil ditambahkan'
          })
          this.uploadPercentage = 0
          this.getTeachers()
        }
      })
      .catch(err => {
        this.$notify({
          group: 'notif',
          position: 'top right',
          type: 'error',
          title: 'Error',
          text: 'Data gagal ditambahkan'
        })
      })

    },
    openModalEdit(item) {
      this.$modal.show('edit-teacher')
      this.isEdit = true
      this.edit_data = item
    },

    updateData() {

      if (this.image) {
        this.isLoadingButton = true
        
        let formData = new FormData()
        
        formData.append('file', this.file)

        axios.post('/api/update-teacher/', {'image':this.image, 'data':this.edit_data})
        .then(res => {
          if (res.data.error == 'validation') {
            this.isLoadingButton = false
            if (res.data.message.image) {
              this.isError = true
              this.error.message = 'Format file tidak sesuai' 
            } else {
              this.isError = true
              this.error.message = 'Oops ada kesalahan dalam pengisian data'
            }
          } else {
            this.isLoadingButton = false
            this.isEdit = false
            this.$modal.hide('edit-teacher')
            this.edit_data = {}
            this.image = false
            this.$notify({
              group: 'notif',
              position: 'top right',
              type: 'success',
              title: 'Sukses',
              text: 'Data berhasil diubah'
            })
            this.getTeachers()
          }
        })
        .catch(err => {
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'error',
            title: 'Oops ada kesalahan',
            text: 'Data guru gagal diubah'
          })
        })

      } else {  
        axios.post('/api/update-teacher/', this.edit_data)
        .then(res => {
          if (res.data.error == 'validation') {
            this.isLoadingButton = false
            if (res.data.message.image) {
              this.isError = true
              this.error.message = 'Format file tidak sesuai' 
            } else {
              this.isError = true
              this.error.message = 'Oops ada kesalahan dalam pengisian data'
            }
          } else {
            this.isLoadingButton = false
            this.isEdit = false
            this.$modal.hide('edit-teacher')
            this.edit_data = {}
            this.image = false
            this.$notify({
              group: 'notif',
              position: 'top right',
              type: 'success',
              title: 'Sukses',
              text: 'Data berhasil diubah'
            })
            this.getTeachers()
          }
        })
        .catch(err => {
          this.$notify({
            group: 'notif',
            position: 'top right',
            type: 'error',
            title: 'Oops ada kesalahan',
            text: 'Data guru gagal diubah'
          })
        })
      }
    },
    clearData(status) {
      this.image = null
      if (status == 'edit') {
        this.$modal.hide('edit-teacher')
        this.edit_data = {}
        this.isEdit = false
      } else if (status == 'add') {
        this.$modal.hide('add-teacher')
        this.new_data = {}
        this.image = false
        this.error = {}
        this.isError = false
        this.errorImage = false
      }
    },
    deleteData(id) {
      this.isLoadingButton = true
      this.$modal.show('dialog', {
        title: '🙄 Konfirmasi hapus data',
        text: 'Apakah anda ingin menghapus data guru ini?',
        buttons: [
          {
            title: '✔ Lanjutkan',
            default: true,
            handler: () => { 
                axios.post('/api/delete-teacher/'+id)
                .then(res => {
                  this.isLoadingButton = false
                  this.$modal.hide('dialog')
                  this.$notify({
                    group: 'notif',
                    position: 'top right',
                    type: 'success',
                    title: 'Sukses',
                    text: 'Data guru berhasil dihapus'
                  });
                  this.getTeachers()
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
                  this.getTeachers()
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
                title: 'Perintah dibatalkan',
                text: 'Data guru tidak dihapus'
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
