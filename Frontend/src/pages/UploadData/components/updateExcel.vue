<script setup lang="ts">
import axios from "axios";
import { defineEmits, defineProps, onMounted, reactive } from "vue";
import Table from "./Table.vue"
const state = reactive({
  sheets:undefined,
  files:undefined,
  headers:undefined,
  sheetShow:undefined,
})
const emits = defineEmits(['nextStep'])
const props = defineProps(['sessionId'])

onMounted(()=>{
  getData()
})

function getData(){
  let response = axios.get(
    "http://localhost:8080/getUploadData/" + props.sessionId
  );
  response.then((res) => {
    state.files = res.data.files
    setValues(res.data.files);
  });
}

// setting headers and sheet
function setValues(files) {
  let sheets = [];
  // let headers = [];
  files.map((file) => {
    file.sheet?.map((singleSheet) => {
      sheets.push(singleSheet);
    });
  });
  //removing duplications
  let unique = [];
  sheets.map((x) =>
    unique.filter((a) => a.sheet_name === x.sheet_name).length > 0
      ? null
      : unique.push(x)
  );
  state.sheets = unique;
}
  
function tabClick(id){
  state.sheetShow = id
}
</script>

<template>
  <div>
    <VRow>
        <v-col cols="6">
          <h2>Step:3 - Sheets and Headers</h2>
        </v-col>
        <v-col cols="6">
          <v-btn class="float-right" @click="emits('nextStep')">
          Next
          </v-btn>
        </v-col>

        <v-col cols="12">
          <nav class="mt-1">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <!--        Summary btn-->
              <button
                v-for="sheet in state.sheets" 
                :key="sheet.id"
                class="nav-link"
                id="nav-home-tab"
                type="button"
                role="tab"
                @click="tabClick(sheet.id)"
              >
              <span>
                {{ sheet.sheet_name }}
      
              </span>
                <b class=" pointer-event float-right color-red" @click="deleteData('sheet', sheet.sheet_name)">X</b>
              </button>
            </div>
          </nav>
        </v-col>
        <v-col>
          <Table :headers="state.headers" :data="state.data" :sheetShow="state.sheetShow" v-if="state.sheetShow != undefined" />
        </v-col>
    </VRow>
  </div>
</template>
<style lang="scss" scoped>
    .transform-box {
      //border: #6f42c1 1px dashed;
      height: 300px;
      .badge {
        cursor: pointer;
      }
      overflow: auto;
    }
    .nav-link {
      padding: 5px;
      transform: skew(35.5deg);
      width: 180px;
      border-top-right-radius: 6px;
      border-top-left-radius: 24px;
      background-color: #e4e5e5;
      color: black;
    }
    
    .nav-link:first-child::before {
      border-top-left-radius: 20px;
      content: "";
      background: inherit;
      width: 17px;
      position: absolute;
      transform: skew(326deg);
      top: 0px;
      left: -4px;
    }
    
    .nav-link span {
      transform: skew(-35.5deg);
      display: inline-block;
    }
    .pointer-event{
      cursor: pointer;
    }
    </style>
    