<template>
  <section>
    <div class="field">
      <b-switch v-model="newProject">Create new Project</b-switch>
    </div>

    <b-field v-if="newProject" label="ProjectName">
      <b-input v-model="projectName"></b-input>
    </b-field>
    <b-field>
      <b-upload name="files" @input="checkFiles()" v-model="dropFiles" multiple drag-drop expanded>
        <section class="section">
          <div class="content has-text-centered">
            <p>
              <b-icon icon="upload" size="is-large"> </b-icon>
            </p>
            <p>Drop your files here or click to upload</p>
          </div>
        </section>
      </b-upload>
    </b-field>

    <div class="tags">
      <span
        v-for="(file, index) in dropFiles"
        :key="index"
        class="tag is-primary"
      >
        {{ file.name }}
        <button
          class="delete is-small"
          type="button"
          @click="deleteDropFile(index, $event)"
        ></button>
      </span>
    </div>
    <div class="field is-grouped m-t-md is-pulled-right">
      <div class="control">
          <b-dropdown v-model="isPublic" aria-role="list">
            <button class="button is-primary" type="button" slot="trigger">
              <template v-if="isPublic">
                <span>Public</span>
              </template>
              <template v-else>
                <span>Friends</span>
              </template>
            </button>

            <b-dropdown-item :value="true" aria-role="listitem">
              <div class="media">
                <div class="media-content">
                  <h3>Public</h3>
                  <small>Everyone can see</small>
                </div>
              </div>
            </b-dropdown-item>

            <b-dropdown-item :value="false" aria-role="listitem">
              <div class="media">
                <div class="media-content">
                  <h3>Friends</h3>
                  <small>Only friends can see</small>
                </div>
              </div>
            </b-dropdown-item>
          </b-dropdown>
      </div>
      <div class="control">
        <button @click="submit()" class="button is-link">Submit</button>
      </div>
      <div class="control">
        <button class="button is-link is-light">Back</button>
      </div>
    </div>
    <div class="is-clearfix"></div>
  </section>
</template>



<script>
export default {
  data() {
    return {
      dropFiles: [],
      projects: '',
      isPublic: true,
      newProject: true,
      projectName: ''
    };
  },
  methods: {
    submit() {
        let formData = new FormData();
        for(let i = 0; i < this.dropFiles.length; i++ ) {
          let file = this.dropFiles[i];
          formData.append('files[' + i + ']', file);
        }
        this.$http.post('/api/projects', formData, {
          headers: {
            'x-project-title' : this.projectName
          }
        }
        );
    },
    deleteDropFile(index, e) {
        console.log(e, e.currentTarget)
      this.dropFiles.splice(index, 1);
    },
    checkFiles() {
        console.log(this.dropFiles);
    }
  },
};
</script>
