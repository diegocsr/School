<template>
  <div class="container">
    <div class="w-full">
        
        <title-section :title="'Informasi Akun Admin'" :subtitle="'Semua informasi terkait akun admin website sekolah'"></title-section>

      <!-- DISPLAY account -->
      <div class="flex w-full align-middle items-center">
        <div class="w-full border border-grey-light p-8 bg-white rounded">
        <div class="w-full mb-8 block">
          <a href="#" @click.prevent="addAccount()" class="btn-blue btn-md">
            <i class="fa fa-plus"/> Tambah</a>
        </div>
        <table class="table-auto block">
          <thead>
            <tr>
              <th width="350">Nama</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="isLoading">
              <td v-for="n in 5" :key="n"><text-loading></text-loading></td>
            </tr>
            <tr v-if="!isLoading && accounts.length > 0" v-for="(item, index) in accounts" :key="index">
              <td>{{ item.name }}</td>
              <td>{{ item.email }}</td>
              <td>
                <a href="#" @click.prevent="openModalEdit(item)" class="btn-blue btn-sm">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="#" @click.prevent="deleteData(item.id)" class="btn-red btn-sm">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
            </tr>
            <tr v-if="!isLoading && accounts.length == 0">
              <td colspan="5" align="center">Data Siswa kosong</td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
      <!-- END DISPLAY account -->

      <!-- MODAL CREATE -->
      <modal name="add-account" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Tambah data siswa</div>
          <div class="flex">
            <div class="w-1/2">
              <small class="label mt-6">Nama</small>
              <input class="form-default" type="text" v-model="new_data.name" required>
              <small class="label mt-6">Email</small>
              <input class="form-default" type="email" v-model="new_data.email" required>
              <small class="label mt-6">Password</small>
              <input class="form-default" type="password" v-model="new_data.password" required>
            </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('add')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="submitData()" class="btn-blue btn-md">
            <i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-blue btn-md"><spinner></spinner></a>
          </div>
        </div>
        </div>
      </modal>
      <!-- END MODAL CREATE -->

      <!-- MODAL EDIT -->
      <modal name="edit-account" class="rounded" height="auto" :scrollable="true">
        <div class="p-6">
          <div class="text-xl block w-full font-semibold mb-1 pb-4 border-b border-grey-light"><i class="fa fa-info-circle text-grey-dark"/> Ubah data guru</div>
          <div class="flex">
            <div class="w-1/2">
              <small class="label mt-6">Nama</small>
              <input class="form-default" type="text" v-model="edit_data.name" required>
              <small class="label mt-6">Email</small>
              <input class="form-default" type="email" v-model="edit_data.email" required>
              <!-- <small class="label mt-6">Password</small>
              <input class="form-default" type="password" v-model="edit_data.password" required> -->
            </div>
          <div class="w-full mt-8 block">
            <button v-if="!isLoadingButton" href="#" @click="clearData('edit')" class="btn-grey btn-md">
            <i class="fa fa-close"/> Batal</button>
            <button v-if="!isLoadingButton" href="#" @click="updateData()" class="btn-indigo btn-md">
            <i class="fa fa-save"/> Simpan</button>
            <a v-if="isLoadingButton" href="#" class="btn-blue btn-md"><spinner></spinner></a>
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
      accounts: false,
      isEdit: false,
      isLoading: false,
      isLoadingButton: false,
      isError: false,
      error: {
        message: '',
      },
      new_data: {},
      edit_data: {},
    }
  },
  mounted() {
    this.getAccounts()
  },
  methods: {
    getAccounts() {
      this.isLoading = true
      axios.get('/api/account')
      .then(res => {
        this.isLoading = false
        this.accounts = res.data.results
      })
      .catch(err => {
        alert("oops error")
      })
    },
    addAccount() {
      this.$modal.show('add-account')
    },
    submitData() {
      this.isLoadingButton = true
            
      let formData = new FormData()
      
      axios.post('/api/submit-account/', {'data': this.new_data})
      .then(res => {
        if (res.data.error == 'validation') { 
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('add-account')
          console.log(res.data.result)
          alert(res.data.status)
          this.new_data = {}
          this.getAccounts()
        }
      })
      .catch(err => {
        alert(err)
      })

    },
    openModalEdit(item) {
      this.$modal.show('edit-account')
      this.edit_data = item
    },

    updateData() {
      this.isLoadingButton = true
      
      let formData = new FormData()
      
      axios.post('/api/update-account/', {'data': this.edit_data})
      .then(res => {
        if (res.data.error == 'validation') {
          this.isLoadingButton = false
        } else {
          this.isLoadingButton = false
          this.$modal.hide('edit-account')
          console.log(res.data.result)
          alert(res.data.status)
          this.edit_data = {}
          this.getAccounts()
        }
      })
      .catch(err => {
        alert(err)
      })
    },
    clearData(status) {
      if (status == 'edit') {
        this.$modal.hide('edit-account')
        this.edit_data = {}
      } else if (status == 'add') {
        this.$modal.hide('edit-account')
        this.new_data = {}
      }
    },
    deleteData(id) {
      axios.post('/api/delete-account/'+id)
      .then(res => {
        alert('behasil')
        this.getAccounts()
      })
      .catch(err => {
        alert(err)
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
