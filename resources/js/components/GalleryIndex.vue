<template lang="html">
  <div>
    <div class="py-3 d-flex justify-content-between">
      {{ displayData }}
      <button
        type="button"
        @click="filters.onlyStared = !filters.onlyStared"
        :class="{'btn': true,  'btn-outline-primary': !filters.onlyStared, 'btn-primary': filters.onlyStared}"
        name="button">Only Show <i class="far fa-star"></i></button>
    </div>
    <h2
      v-if="loading"
      class="text-center my-4">Loading Media...
    </h2>
    <div
      v-for="(mediaChunk, key) in chunkedMedia"
      :key="key"
      class="row my-3 py-4">
      <div
        v-for="m in mediaChunk"
        :key="m.id"
        class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
          <lightbox
            :thumbnail="m.src"
            :images="mediaUrls(m)">
              <lightbox-default-loader slot="loader"></lightbox-default-loader>
          </lightbox>
          <a
            :href="m.src"
            title="Download"><i class="far fa-download"></i></a>
          <a
            href="#"
            @click="(e) => addStar(e, m)"><i :class="{'far': !stared.includes(m.id), 'fas': stared.includes(m.id), 'fa-star': true}"></i></a>
          <p class="mb-0"><i class="far fa-user-circle"></i> <strong v-if="m.custom">{{ m.custom.name }}</strong></p>
          <p><small><i class="far fa-clock"></i> <strong v-if="m.created_at">{{ m.created_at }}</strong></small></p>
      </div>
    </div>

    <div class="text-center">
      <button
        :disabled="loading || !metaLinks.next"
        @click="getMedia"
        type="button"
        class="btn btn-primary"
        name="button">Load More
      </button>
    </div>

    <div class="py-3">
      {{ displayData }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'GalleryIndex',

  props: {
    apiUrl: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      media: [],
      loading: false,
      metaLinks: {
        first: null,
        last: null,
        next: `${this.apiUrl}/uploads`,
        prev: null
      },
      meta: {},
      stared: [],
      filters: {
        onlyStared: false
      }
    }
  },

  mounted () {
    if (localStorage.getItem('staredItems')) {
      this.stared = JSON.parse(localStorage.getItem('staredItems'))
    }
    this.getMedia()
  },

  watch: {
    stared (val) {
      localStorage.setItem('staredItems', JSON.stringify(val))
    }
  },

  computed: {
    filteredMedia () {
      if (this.filters.onlyStared) {
        return window._.filter(this.media, (m) => { return this.stared.includes(m.id) })
      }
      return this.media
    },

    chunkedMedia () {
      return window._.chunk(this.filteredMedia, 4)
    },

    displayData () {
      return this.meta.total ? `Showing ${this.filteredMedia.length} out of ${this.meta.total}` : ''
    }
  },

  methods: {
    mediaUrls (media) {
      var urls = []
      var newMedia = this.filteredMedia.slice(this.filteredMedia.indexOf(media))
      newMedia.forEach((m) => {
        urls.push(m.src)
      })
      return urls
    },

    addStar (e, m) {
      e.preventDefault()
      if (this.stared.includes(m.id)) {
        this.stared.splice(this.stared.indexOf(m.id), 1)
      } else {
        this.stared.push(m.id)
      }
    },

    getMedia () {
      this.loading = true
      window.axios.get(this.metaLinks.next)
        .then((data) => {
          data.data.data.forEach((media) => {
            this.filteredMedia.push(media)
          })
          this.meta = data.data.meta
          this.metaLinks = data.data.links
          this.loading = false
        })
    }
  }
}
</script>

<style lang="css">
</style>
