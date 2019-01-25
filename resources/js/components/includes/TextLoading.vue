<template>
  <div>
    <div v-for="n in 1" :key="n">
      <div class="load-body-1"></div>
      <div class="load-body-2"></div>
    </div>
  </div>
</template>

<style scoped>
.load-body-1 {
  height: 15px;
  margin-bottom: 10px;
}
.load-body-2 {
  height: 15px;
  margin-bottom: 10px;
  width: 40%;
}
</style>