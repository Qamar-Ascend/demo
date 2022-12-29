<script setup lang="ts">
import axios from 'axios'
import { defineEmits, defineProps, onMounted, reactive } from 'vue'

const props = defineProps(['sessionId'])
const emits = defineEmits(['nextStep'])
const state = reactive({
  status: 0,
})
let intervalId

onMounted(() => {
  getData()
  intervalId = setInterval(getData, 10000)
})

onUnmounted(() => clearInterval(intervalId))

function getData() {
  const res = axios.get(`http://localhost:8080/getSessionStatus/${props.sessionId}`)
  res.then(resp => {
    const completed = resp.data.data.completed_sheets
    const total = resp.data.data.total_sheets
    const percentage = (completed / total) * 100
    state.status = percentage
    if (percentage === 100)
      emits('nextStep')
  })
}
</script>

<template>
  <div>
    <VRow>
      <VCol cols="12">
        <h2>Step:2 - Extracting Data..</h2>
      </VCol>
      <VCol
        cols="12"
        md="12"
      >
        <VProgressLinear
          v-model="state.status"
          height="25"
        >
          <strong>{{ Math.ceil(state.status) }}%</strong>
        </VProgressLinear>
      </VCol>
    </VRow>
  </div>
</template>
