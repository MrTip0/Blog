<template>
   <div class="mb-3 input-group">
      <input class="form-control" type="file" id="upImmagine" @change="handleFileUpload( $event )">
      <button class="btn btn-secondary" v-on:click="submitFile()">Submit</button>
   </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";


export default defineComponent({
   data(){
      return {
         file: ''
      }
   },
   
   methods: {
      handleFileUpload(event: any){
         this.file = event.target.files[0];
      },
      
      submitFile(){
         let formData = new FormData();
         
         formData.append('fileToUpload', this.file);
         
         fetch("/postapi/uploadimg.php", {
            method: "POST",
            body: formData
         }).then(res => res.json())
         .then(res => {
            if (res.result == 'failure') {
               alert(res.reason)
            } else {
               this.$emit('uploaded', res.url)
            }
         })
      }
   }
})
</script>