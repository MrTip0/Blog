<script>
import '@uppy/core/dist/style.css'
import '@uppy/dashboard/dist/style.css'
import '@uppy/progress-bar/dist/style.css'

import Uppy from '@uppy/core'
import { Dashboard, ProgressBar } from '@uppy/vue'
import XHRUpload from '@uppy/xhr-upload'

export default {
   components: {
      Dashboard,
      ProgressBar
   },
   computed: {
      uppy: () => {
         return new Uppy().use(XHRUpload, {
            endpoint: '/postapi/uploadimg.php',
            fieldName: 'fileToUpload'
         }).on('upload-success', (file, result) => {
            this.$emit('uploaded', {url: result.body.url, name: file.name})
         })
      }
   },
  beforeDestroy () {
    this.uppy.close()
  }
}
</script>

<template>
   <div>
      <dashboard :uppy="uppy"/>
      <progress-bar :uppy="uppy"/>
   </div>
</template>