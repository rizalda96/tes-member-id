<template>
  <div>
    <b-row class="d-flex justify-content-center mt-5">
       <b-card title="Award Login">
          <b-card-text>
            Enter email address to sign and continue
          </b-card-text>

          <form @submit.prevent="onLogin" id="form-login">
            <template v-if="message">
              <b-alert variant="danger" show>Email is not exist</b-alert>
            </template>
            <template>
              <b-form-group
                label="Email"
                label-for="email"
              >
                <b-form-input
                  id="email"
                  type="email"
                  required
                  placeholder="admin@admin.com"
                  v-model="model.email"
                  trim
                ></b-form-input>
              </b-form-group>
            </template>
            <b-button type="submit" variant="secondary">
              Sign in
            </b-button>
          </form>
        </b-card>
    </b-row>
  </div>
</template>

<script>
  export default {
    name: 'login',
    data() {
      return {
        model: {
          email: null
        },
        message: null
      }
    },
    methods: {
      async onLogin() {
        let action = this.$app.route('login')

        this.$http.post(action, this.model)
        .then(response => {
          if (response.data.data) {
            return this.$router.push({name: 'award-list'})
          }
          this.message = 'Email is not exist'
        })
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>
