<script setup lang="ts">
import { reactive } from 'vue';
import CreateSession from "./components/creatingSession.vue";
import UpdateExcel from "./components/updateExcel.vue";
import UploadFiles from "./components/uploadFiles.vue";
import SelectDataSource from "./components/selectDataSource.vue";
import DataSourceAppendingData from "./components/DataSourceAppendingData.vue";
const state = reactive({
  "step": 1,
  "sessionId": undefined
})
function nextStep(){
  state.step++
}

function setSessionId(id){
  state.sessionId = id
}
</script>

<template>
  <div>
    <VRow>
      <VCol
      cols="12"
      md="12"
    >
    <!-- 👉 Horizontal Form -->
    <VCard >
      <VCardText>
          <!-- Step 1 upload files -->
          <UploadFiles v-if="(state.step === 1)" @nextStep="nextStep" @setSessionId="setSessionId"/>
          <!-- Step 2 loading/creating Session -->
          <CreateSession v-if="(state.step === 2)" @nextStep="nextStep" :sessionId="state.sessionId" />
          <!-- Step 3 Select sheets and headers -->
          <UpdateExcel  v-if="(state.step === 3)" :sessionId="state.sessionId" @nextStep="nextStep"/>
          <!-- Step 4 -->
          <SelectDataSource  v-if="(state.step === 4)" :sessionId="state.sessionId" @nextStep="nextStep"/>
          <!-- Step 5 -->
          <DataSourceAppendingData  v-if="(state.step === 5)" :sessionId="state.sessionId" @nextStep="nextStep"/>
        </VCardText>
      </VCard>
    </VCol>
    </VRow>
  </div>
</template>
