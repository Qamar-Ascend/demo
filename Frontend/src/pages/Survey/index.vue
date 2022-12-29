<script setup lang="ts">
import { ApiService } from "@/services/ApiService";
import { onMounted, reactive } from "vue";

onMounted(() => {
  getData();
});

 const state = reactive({
  dataSources:[]
 })

function getData() {
  const res = ApiService.query("surveys");
  res.then((resp) => {
    
    const dataSources = resp.data?.data;
    state.dataSources = dataSources;
  });
}

</script>

<template>
  <div>
    <VRow>
      <VCol cols="12">
        <VCard title="Survey - Listing">
          <VTable
          min-height="250"
          fixed-header
        >
          <thead>
            <tr>
              <th class="text-uppercase">
                Name
              </th>
              <th class="text-center text-uppercase">
                Created at
              </th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <tbody>
           <tr v-for="data in state.dataSources" :key="data.id">
            <td class=" text-uppercase">
              {{data.name}}
            </td>
              <td class="text-center text-uppercase">
              {{data.created_at}}
            </td>
           </tr>
          </tbody>
        </VTable>
        </VCard>
      </VCol>
    </VRow>
  </div>
</template>
