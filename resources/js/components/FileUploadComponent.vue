<template lang="html">
  <div>
    <div
      class="form-group text-left d-block m-auto pb-4"
      style="max-width: 300px">
      <label
        for="name">Name</label>
      <input
        v-model="name"
        type="text"
        autofocus
        class="form-control"
        id="name"
        aria-describedby="name"
        placeholder="Enter name">
      <small
        id="emailHelp"
        class="form-text text-muted">Please enter your name before submitting photos.</small>
    </div>

    <file-upload-button :api-url="apiUrl"
                        :extra-data="{ name: name }"
                        :disabled="name ? false : true"
                        :button="{ text: 'Upload Images' }" />
  </div>
</template>

<script>
export default {
  name: 'FileUploadComponent',

  props: {
    apiUrl: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      name: null
    }
  }
}
</script>

<style lang="css">
</style>
