<script setup>
import { onMounted, reactive, watch } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
let route = useRoute();
const state = reactive({
  files: [],
  sheets: [],
  headers: [],
  data: [],
  table: [],
  skip: [],
  page:1,
});
const props = defineProps(["headers", "data", "sheetShow"]);
const emit = defineEmits(['deleteData','skipSheets'])


watch(() => props.sheetShow, (first, second) => {
  transformData();
});

onMounted(() => {
  transformData();
});

function transformData() {
    let response = axios.post(
      "http://localhost:8080/TransformData/" + route.params.id+"/"+props.sheetShow
    );
    response.then((e) => {
      setTable(e.data.data);
    });
}

function setTable(data) {
  let finalDala = [];
  let headers = []
  Object.entries(data[0].Data).forEach(
    ([key, value]) =>{
      console.log(key,value);
      headers.push(key)
    } 
);
let toRemove = ['_id', 'path', 'session_id', 'sheet_id', 'status', 'rowNumber']
headers = headers.filter( function( el ) {
  return !toRemove.includes( el );
} );

state.headers = headers

  data.map((d,index) => {
    // let arrayData = [];
    // console.log(d);
    // console.log(d.Data);
    // console.log(d.headers);
    let s = {};
  //   Object.entries(data[0].Data).forEach(
  //     ([key, value]) =>{
  //       headers.push(value)
  //     } 
  // );


    // for (let i = 0; i < headers.length; i++) {
    //   let index = headers[i];
    //   let dataValue = d.Data[headers[i]];
    //   console.log(index,dataValue);
    //    s[index] = dataValue;
    // }
    // finalDala.push(s);

  });
  // console.log(finalDala);
  console.log(data, headers);
  state.data = data;
}

function changeData(event, old, attr){
  let newName = event.target.value;
  var bodyFormData = new FormData();
  bodyFormData.append("newName", newName);
  bodyFormData.append("oldName", old);
  bodyFormData.append("action", attr);
  let response = axios.post(
      "http://localhost:8080/RenameData/" + route.params.id,bodyFormData
    );
    response.then((e) => {
      setTable(e.data.data);
    });
}

</script>

<template>
<v-row>
    <v-col cols="3" offset-md="6">
      <VTextField label="Enter Starting Row Number" type="text"  persistent-placeholder />
    </v-col>
    <v-col cols="3">
      <VTextField label="Enter Ending Row Number" type="text"  persistent-placeholder/>
    </v-col>
</v-row>
<v-row>
  <v-col cols="12">
    <table class="table table-striped w-100">
    <tbody class="w-100">
      <tr v-for="(data, index) in state.data" :key="data">
       <td v-for="(head) in state.headers" :key="head" class="col"  >
        {{data.Data[head]}}
       </td>
      </tr>
    </tbody>
  </table>
  </v-col>
  <v-col cols="12" v-if=state.data.length>
    <v-pagination
      v-model="state.page"
      :length="15"
      :total-visible="7"
    ></v-pagination>
  </v-col>
</v-row>
      <!-- <label for="">Skip Rows </label>
      <input type="number" class="form-control skipper mb-1" @input="emit('skipSheets',$event,props.sheetShow)"> -->
  
</template>

<style scoped>
  .min-w-10{
    min-width: 200px;
  }
  .skipper{
    width: 300px;
  }
  tr:first{
    background-color:grey;
    font-weight:bold;
  }
  input{
    height:20px
  }
</style>
