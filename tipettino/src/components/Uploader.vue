<template>
	<div class="container">
		<div>
			<label class="input-group">File
				<input type="file" @change="handleFileUpload( $event )"/>
			</label>
			<button class="btn btn-secondary" v-on:click="submitFile()">Submit</button>
		</div>
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
            this.$emit('uploaded', {url: res.url})
         })
      }
   }
})
</script>