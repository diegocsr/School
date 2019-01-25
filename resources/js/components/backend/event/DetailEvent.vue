<template>
  <div class="container">
    <div class="w-full">

      <div class="w-3/4 border border-grey-light p-8 bg-white rounded">

        <a href="/event-sekolah" class="block mb-6" title="Kembali ke daftar event">
          <i class="fa fa-arrow-left btn-round bg-grey hover:bg-grey-dark"/>
        </a>

        <div class="w-full h-48 rounded-lg bg-cover no-repeat block mb-6" :style="'background-image: url('+event.photo+');'"></div>
        <h1>{{ event.title }}</h1>
        <div class="mt-6 text-base text-grey-dark">
          <div class="flex items-center justify-between">
            <div>
              {{ event.created_at | moment("DD MMMM YYYY") }} | 
              {{ event.category.name }} | 
              <span v-if="event.status" class="btn-green btn-sm">Published</span>
              <span v-if="!event.status" class="btn-grey btn-sm">Unpublished</span>
            </div>
            <div>
              <a :href="'/ubah-event/'+ event.slug" class="btn-blue btn-sm">
                <i class="fa fa-edit"></i> Edit event
              </a>
            </div>
          </div>
        </div>
        <div class="mt-12">
          <div v-html="event.body"></div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  props: ['event'],
  data() {
    return {

    }
  }
}
</script>
