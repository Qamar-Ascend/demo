<script setup>
import { reactive, ref, defineEmits, defineProps } from "vue";
import FileUpload from "vue-upload-component";
import axios from "axios";
const emits = defineEmits(['nextStep', 'setSessionId'])
const upload = ref(false);

const files = ref([]);

const state = reactive({
  filesIds: [],
  loader : false
});


function inputFile(newFile, oldFile) {
  if (newFile && oldFile && !newFile.active && oldFile.active) {
    // Get response data
    console.log("response", newFile.response);
    if (newFile.xhr) {
      //  Get the response status code
      if (newFile.xhr.status === 200) {
        let ids = state.filesIds;
        ids.push(newFile.response.data.id);
        state.filesIds = ids;
      }
    }
  }
}

function next(){
  state.loader = true
  let bodyFormData = new FormData();
  bodyFormData.append('ids', state.filesIds);
  let res = axios.post("http://localhost:8080/createSession", bodyFormData)
  res.then((resp)=>{
    let id = resp.data?.data?.id
    if(id){
      emits('setSessionId', id)
      emits('nextStep')
    }
    
  })
}
</script>

<template>
  <v-row>
    <v-progress-linear
      indeterminate
      color="green"
      v-if="(upload.active  || state.loader === true)"
    ></v-progress-linear>
  <br/>
  <v-col cols="12" class="ps-0">
  <h3>Step:1 - Upload Files</h3>
  </v-col>
    <v-col class="dropbox"  >
      <file-upload
        class="v-btn v-theme--light bg-primary v-btn--density-default v-btn--size-default "
        post-action="http://localhost:8080/storeFiles"
        extensions="xlsx"
        accept="xlsx"
        :multiple="true"
        :size="1024 * 1024 * 10"
        v-model="files"
        @input-file="inputFile"
        ref="upload"
    >
      <i class="fa fa-plus"></i>
      Select files
  </file-upload>
    </v-col>
    <v-col class="ps-9" cols="6" v-if="files.length" >
      <ul>
        <li v-for="file in files" :key="file.id">
          <span>{{ file.name }}</span> - <span>{{ file.size }}</span> -
          <span v-if="file.error">{{ file.error }}</span>
          <span v-else-if="file.success" class="badge-success text-white pa-1">success</span>
          <span v-else-if="file.active">active</span>
          <span v-else-if="!!file.error">{{ file.error }}</span>
          <span v-else></span>
        </li>
      </ul>
      <div>
       
        <v-btn
        class="float-right ml-2"
        v-if="files.length"
        :disabled="upload.active"
        @click="next"
        >
        Next
        </v-btn>
        <v-btn
        class="float-right"
        v-if="files.length"
        :disabled="upload.active"
        @click.prevent="upload.active = true"
        >
        Upload
      </v-btn>
      </div>
      
      
    </v-col>
    <v-col cols="12">
      <!-- <v-btn class="ma-1 float-right"  v-if="files.length" @click="next">
        Next
      </v-btn> -->
    </v-col>
  </v-row>
  <!-- <div class="row">
    <div class="example-simple">
      <div class="col-6">
        <h1>Upload Data</h1>
      </div>
      <div class="col-6">
        <button class="btn btn-primary" @click="next">Next</button>
      </div>
      <div class="upload">
        <ul>
          <li v-for="file in files" :key="file.id">
            <span>{{ file.name }}</span> - <span>{{ file.size }}</span> -
            <span v-if="file.error">{{ file.error }}</span>
            <span v-else-if="file.success">success</span>
            <span v-else-if="file.active">active</span>
            <span v-else-if="!!file.error">{{ file.error }}</span>
            <span v-else></span>
          </li>
        </ul>
        <div class="example-btn">
       
          <button
            type="button"
            class="btn btn-success"
            v-if="!upload || !upload.active"
            @click.prevent="upload.active = true"
          >
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
            Start Upload
          </button>
          <button
            type="button"
            class="btn btn-danger"
            v-else
            @click.prevent="upload.active = false"
          >
            <i class="fa fa-stop" aria-hidden="true"></i>
            Stop Upload
          </button>
        </div>
      </div>
    </div>
  </div> -->
</template>
<style lang="scss" scoped>
.dropbox{
  height:200px;
  border:1px dotted grey;
  display: flex;
  justify-content: center;
}
.v-btn{
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 70px;
}

</style>
