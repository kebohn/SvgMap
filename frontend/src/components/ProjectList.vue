<template>
  <section>
    <div class="buttons">
    <b-button type="is-primary" @click="selected = null"
            :disabled="!selected" icon-left="times">
      Clear selection
    </b-button>
    <b-button type="is-primary" :disabled="!selected" icon-left="trash" @click="confirmDeleteProject">
      Delete
    </b-button>
    <b-button type="is-primary" :disabled="!selected" icon-left="folder" @click="openProject">
      Open Project
    </b-button>
  </div>
    <b-tabs>
      <b-tab-item >
        <b-table
                :data="projects"
                :columns="columns"
                :selected.sync="selected"
                focusable>
        </b-table>
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
      },
      confirmDeleteProject() {
        this.$buefy.dialog.confirm({
          title: 'Deleting Project',
          message: `Are you sure you want to <b>delete Project ${this.selected.name}</b>? This action cannot be undone.`,
          confirmText: 'Delete Project',
          type: 'is-danger',
          hasIcon: true,
          onConfirm: () => {
            this.deleteProject();
          }
        })
      },
      deleteProject() {
        this.$http.delete(`/api/projects/${this.selected.id}`)
            .then(response => {
              if (response.status === 200) {
                if(this.removeDeletedProjectFromArray()) {
                  this.$buefy.toast.open('Project deleted!');
                }
              } else {
                this.$buefy.toast.open(`Project could not be deleted!\n (${response.status})`);
              }
            })
            .catch(error => {
              this.$buefy.toast.open(`An error occurred, please try again!\n ${error}`);
            });
      },
      removeDeletedProjectFromArray() {
        let idx = this.projects.indexOf(this.selected);
        if (idx !== -1) {
          this.projects.splice(idx,1)
          this.selected = null;
          return true;
        }
        return false;
      },
      openProject() {
        this.$router.push({ name: 'Project', params: {id: this.selected.id }})
      }
    }
  }
</script>