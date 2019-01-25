<template>
  <div>
    <div>
      <div class="load-body-0"></div>
    </div>
    <div v-for="n in 3" :key="n" class="mb-10">
      <div class="load-body-1"></div>
      <div class="load-body-1"></div>
      <div class="load-body-1"></div>
      <div class="load-body-2"></div>
    </div>
  </div>
</template>

<style scoped>
.load-body-0 {
  height: 25px;
  margin-bottom: 45px;
}
.load-body-1 {
  height: 15px;
  margin-bottom: 10px;
}
.load-body-2 {
  height: 15px;
  margin-bottom: 10px;
  width: 60%;
}
</style>