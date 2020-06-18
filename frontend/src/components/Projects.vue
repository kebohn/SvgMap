<template>
  <section>
    <button class="button field is-danger" @click="selected = null"
            :disabled="!selected">
      <b-icon icon="times"></b-icon>
      <span>Clear selected</span>
    </button>

    <b-tabs>
      <b-tab-item label="Table">
        <b-table
                :data="projects"
                :columns="columns"
                :selected.sync="selected"
                focusable>
        </b-table>
      </b-tab-item>

      <b-tab-item label="Selected">
        <pre>{{ selected }}</pre>
      </b-tab-item>
    </b-tabs>
  </section>
</template>

<script>
  export default {
    data() {
      return {
        projects: [],
        selected: null,
        columns: [
          {
            field: 'name',
            label: 'ProjectName',
          }
        ]
      }
    },
    mounted: function () {
      this.fetchProjects();
    },
    methods: {
      fetchProjects() {
        this.$http.get('/api/projects').then(response => {
          this.projects = response.data
        });
      }
    }
  }
</script>