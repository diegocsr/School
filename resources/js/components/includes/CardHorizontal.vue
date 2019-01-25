<template>
  <div class="flex justify-between content-start flex-wrap">
    <div v-for="n in 2" :key="n" class="max-w-md w-1/2 lg:flex pr-6 mb-6 relative">
      <!-- <div class="absolute w-full" style="width: 95.2%; height: 100%;">
        <div class="card-horizontal z-index-10 h-full border-grey-dark rounded w-full">
          <div class="m-auto w-2/3 text-center" style="top: 35%; position: relative">
                  
            <a href="#" title="Unpublish data dari web">
              <i class="fa fa-arrow-down btn-round bg-grey hover:bg-grey-dark"/>
            </a>
            <a href="#" title="Edit data prestasi">
              <i class="fa fa-edit btn-round bg-green hover:bg-green-dark"/>
            </a>
            <a  href="#" title="Lihat detail prestasi">
              <i class="fa fa-eye btn-round bg-indigo hover:bg-indigo-dark"/>
            </a>
            <a href="#" title="Hapus data prestasi">
              <i class="fa fa-trash btn-round bg-red hover:bg-red-dark"/>
            </a>

          </div>

        </div>
      </div> -->
      <div class="h-32 lg:h-auto lg:w-32 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden bg-grey">
      </div>
      <div class="card-horizontal h-32 lg:border-l-0 lg:border-t lg:border-grey-light lg:rounded-b-none lg:rounded-r w-full">
        <div class="mb-8">
          <div class="load-body-2"></div>
          <div class="load-body-3"></div> 
          <div class="load-body-4"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.load-body-2 {
  height: 15px;
  margin-bottom: 10px;
  width: 100%;
}
.load-body-3 {
  height: 15px;
  margin-bottom: 10px;
  width: 80%;
}
.load-body-4 {
  height: 15px;
  margin-top: 30px;
  width: 30%;
}
</style>
