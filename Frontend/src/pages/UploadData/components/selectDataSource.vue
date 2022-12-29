<script setup lang="ts">
import axios from "axios";
import { defineEmits, defineProps, onMounted, reactive } from "vue";

const props = defineProps(["sessionId"]);
const emits = defineEmits(["nextStep"]);
const state = reactive({
  allDataSources: [],
  dataSources: [],
  selectSource: undefined,
  selectObjSource: undefined,
  session: undefined,
  sheetName: [],
  selectedSheet: undefined,
  sheetHeaders:[],
  isNew:false,
  loader: false
});

onMounted(() => {
  getData();
  getSessionData();
});

function getSessionData() {
  const res = axios.get(`http://localhost:8080/getSessionStatus/${props.sessionId}`);
  res.then((resp) => {
    state.session = resp.data.data;
    state.sheetName = resp.data.data.Sheets
  });
}

function getData() {
  const res = axios.get("http://localhost:8080/GetDataSources");
  res.then((resp) => {
    const dataSources = resp.data?.data;
    state.allDataSources = dataSources;
  });
}

function onChangeSheet() {
  const res = axios.post(`http://localhost:8080/TransformData/${props.sessionId}/${state.selectedSheet}`);
  res.then((resp) => {
    let sheetHeaders = resp.data.data[0].Data
    setTable(sheetHeaders)
  });
}

state.selectObjSource = computed(() => {
  const newArray = state.allDataSources.filter((el) => {
    return el.id === state.selectSource;
  });

  return newArray[0];
});


function setTable(data) {
  let finalDala = [];
  let headers = []
  let toRemove = ['_id', 'path', 'session_id', 'sheet_id', 'status', 'rowNumber']
  Object.entries(data).forEach(
    ([key, value]) =>{
      if(!toRemove.includes( key )){
        let obj1={};
        obj1[key]=value
        obj1['isNew']=true
        if(state.selectSource){
          let cols = state.selectObjSource?.columns
          if(cols && cols.includes(value)){
            obj1['isNew'] = false
          }
        }
        headers.push(obj1)
      }
    } 
  );
  headers = headers.filter( function( el ) {
    return !toRemove.includes( el.value );
  } );
  state.sheetHeaders = headers

}

function transform(){
  state.loader = true
  const res = axios.post(`http://localhost:8080/StoreDataInDataSources/${props.sessionId}/${state.selectSource}`);
  res.then((resp) => {
    state.loader = false
    emits('nextStep')
    // router.push({ name: "DataSources" });
  });
}

function onChangeHeader(index,value){
  let bodyFormData = new FormData();
  bodyFormData.append('changeName', value.target.value);
  bodyFormData.append('colName', index);
  bodyFormData.append('sheet_id', state.selectedSheet);
  const res = axios.post(`http://localhost:8080/RenameData/${props.sessionId}`,bodyFormData);
  res.then((resp) => {
    getSessionData();
    onChangeSheet()
  });
}

</script>

<template>
  <div>
    <VRow>
      <!--      Head -->
      <VCol cols="6">
        <h2>Step:4 - Select Data Source</h2>
      </VCol>
      <VCol cols="6">
        <VBtn class="float-right" @click="transform"> Transform </VBtn>
      </VCol>
      <!--   Data Source   Dropdown -->
      <VCol cols="6">
        <VSelect
          v-model="state.selectSource"
          clearable
          label=" Select Data Source"
          :items="state.allDataSources"
          item-title="collection_name"
          item-value="id"
          variant="solo"
        />
      </VCol>
      <!--   Sheet   Dropdown -->
      <VCol cols="6">
        <VSelect
          v-model="state.selectedSheet"
          clearable
          label=" Select Sheet"
          :items="state.sheetName"
          item-title="sheet_name"
          item-value="id"
          variant="solo"
          @update:modelValue="onChangeSheet"
        />
      </VCol>
      <!--     Data Source Columns name -->
      <VCol v-if="state.selectObjSource" cols="6">
        <h4>{{ state.selectObjSource?.collection_name }} Columns Names</h4>
        <VListItem v-for="data in state.selectObjSource?.columns" :key="data._id">
          <VListItemContent>
            <VListItemTitle>{{ data }}</VListItemTitle>
          </VListItemContent>
        </VListItem>

        <VListItem
          v-if="
            state.selectObjSource?.columns === null ||
            state.selectObjSource?.columns.length === 0
          "
        >
          <VListItemContent>
            <VListItemTitle>No Columns </VListItemTitle>
          </VListItemContent>
        </VListItem>
      </VCol>
      <VCol cols="6" id="sheet_header_compare_data_source">
        <h4>Sheet Columns Names</h4>
        <VListItem v-for="data in state.sheetHeaders" :key="data._id">
          <VListItemContent>
            <VListItemTitle class="item-list"
            >
            <div v-for="(value, name) in data">
               <input 
               type="text" 
               class="pa-2 input-text" 
              :class="{isNew:data.isNew}"
               v-if="name != 'isNew'" 
               :value="value" 
               @input="onChangeHeader(name,$event)"> 
            </div>
            </VListItemTitle>
          </VListItemContent>
        </VListItem>

        <VListItem
          v-if="
            state.sheetHeaders === null ||
            state.sheetHeaders?.length === 0
          "
        >
          <VListItemContent>
            <VListItemTitle>No Columns </VListItemTitle>
          </VListItemContent>
        </VListItem>
      </VCol>
    </VRow>
    
  </div>
</template>

<style lang="scss" scoped>

</style>
