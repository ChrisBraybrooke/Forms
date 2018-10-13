<template>
  <div>
    <input
      hidden
      class="mb-4"
      type="file"
      ref="files"
      multiple
      @change="handleFiles"/>
    <button
      @click="$refs.files.click()"
      :disabled="loading || disabled"
      :class="mergedButton.class">{{ loading ? mergedButton.loadingText : mergedButton.text }}
    </button>

    <slot
      name="previews"
      :previews="files">
      <div class="row py-5">
        <div
          v-for="(file, key) in files"
          :key="key"
          :class="{'col-md-2 py-4 my-3': true}">
          <div :class="{'img_preview_wrap p-4': true, 'complete': file.id}">
            <p
              v-if="file.id"
              class="uploaded_text">Uploaded 👍</p>
            <img
              v-if="file.preview"
              :src="file.preview.url"
              :alt="file.preview.name"
              :class="{'img_preview mx-2': true, 'complete': file.id}">
          </div>
        </div>
      </div>
    </slot>

    <div
      v-if="errors.message"
      class="alert alert-danger"
      role="alert">
      <strong>{{ errors.message }}</strong>

      <ul v-if="errors.errors">
        <li
          v-for="(e, key) in errors.errors"
          :key="key">{{ e[0] }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FileUploadButton',

  props: {
    button: {
      type: Object,
      required: false,
      default: () => { return {} }
    },
    apiUrl: {
      type: String,
      required: true
    },
    extraData: {
      type: Object,
      required: false,
      default: () => { return {} }
    },
    disabled: {
      type: Boolean,
      required: false,
      default: () => { return falses }
    }
  },

  data () {
    return {
      files: [],
      errors: {},
      loading: false
    }
  },

  computed: {
    defaultButton () {
      return {
        class: 'btn btn-primary btn-lg',
        text: 'Upload',
        loadingText: 'Uploading...'
      }
    },

    mergedButton () {
      return {
        ...this.defaultButton,
        ...this.button
      }
    }
  },

  methods: {
    handleFiles () {
      window._.forEach(this.$refs.files.files, (file) => {
        this.files.push(file)
      })
      this.getImagePreviews()
      this.submitFiles()
    },

    getImagePreviews () {
      window._.forEach(this.files, (file, fileKey) => {
        if ( /\.(jpe?g|png|gif)$/i.test( file.name ) ) {
          let reader = new FileReader()
          reader.addEventListener("load", () => {
              file.preview = {
                url: reader.result,
                name: file.name
              }
          }, false)
          reader.readAsDataURL(file)
        } else {
          this.$nextTick(() => {
            // this.$refs['preview'+parseInt(i)][0].src = '/img/generic.png';
          })
        }
      })
    },

    submitFiles () {
      this.errors = {}
      this.loading = true

      window._.forEach(this.files, (file, fileKey) => {
        if (!file.id) {
          let formData = new FormData()
          formData.append('file', file)

          window._.forEach(this.extraData, (data, key) => {
            formData.append(key, data)
          })

          this.sendData(file, formData, fileKey)
        }
      })
    },

    sendData (file, formData, key) {
      window.axios.post(`${this.apiUrl}/upload`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then((data) => {
          this.loading = false
          this.$set(this.files[key], 'id', data.data.data.id)
          this.$forceUpdate()
        })
        .catch((data) => {
          this.loading = false
          console.log(data.response.status)
          if (parseInt(data.response.status) === 404 || parseInt(data.response.status) === 500) {
            this.errors = { message: 'Error connecting to the server...' }
          } else {
            this.errors = data.response.data
          }
        })
    }
  }
}
</script>

<style lang="css" scoped>
  .img_preview {
    max-width: 100px;
    width: 100%;
  }
  .img_preview_wrap.complete::before {
      content: "";
      background: #00800033;
      padding: 5px;
      display: block;
      position: absolute;
      width: 100%;
      height: 100%;
      left: 0;
      top: 0;
      z-index: 100;
  }
  .img_preview_wrap {
    position: relative;
  }
  p.uploaded_text {
      font-weight: bold;
      color: #405839;
  }
</style>
