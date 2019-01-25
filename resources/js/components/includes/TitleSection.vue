<template>
  <div class="flex items-center justify-between">
    <div>
      <div class="text-xl text-grey-darker font-medium mb-4 mt-4">
        <i class="fa fa-info-circle stroke-current text-grey"></i>
        {{ title }}
      </div>
      <div class="text-sm mb-4">
        {{ subtitle }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['title', 'subtitle']
}
</script>
