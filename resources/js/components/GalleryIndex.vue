<template lang="html">
  <div>
    <div class="py-3">
      {{ displayData }}
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
        class="col-md-2">
          <lightbox
            :thumbnail="m.src"
            :images="mediaUrls(m)">
              <lightbox-default-loader slot="loader"></lightbox-default-loader>
          </lightbox>
          <a :href="m.src">Download</a>
          <p>Uploaded By: <strong v-if="m.custom">{{ m.custom.name }}</strong></p>
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
      meta: {}
    }
  },

  mounted () {
    this.getMedia()
  },

  computed: {
    chunkedMedia () {
      return window._.chunk(this.media, 6)
    },

    displayData () {
      return this.meta.total ? `Showing ${this.meta.to} out of ${this.meta.total}` : ''
    }
  },

  methods: {
    mediaUrls (media) {
      var urls = []
      var newMedia = this.media.slice(this.media.indexOf(media))
      newMedia.forEach((m) => {
        urls.push(m.src)
      })
      return urls
    },

    getMedia () {
      this.loading = true
      window.axios.get(this.metaLinks.next)
        .then((data) => {
          data.data.data.forEach((media) => {
            this.media.push(media)
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
