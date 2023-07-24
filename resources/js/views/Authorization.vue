<template>
  <div class="container__auth">
    <div class="login-box">
      <h2>Авторизация</h2>
      <form @submit.prevent="authorization">
        <div class="user-box">
          <input v-model.trim="state.input__email" type="text" name="" required="">
          <label>Email</label>
          <p v-if="v$.input__email.$error" class="invalid__data">Проверьте правильность полей</p>
        </div>
        <div class="user-box">
          <input v-model.trim="state.input__password" type="password" name="" required="">
          <label>Пароль</label>
          <p v-if="v$.input__password.$error" class="invalid__data">Проверьте правильность полей</p>
        </div>
        <div class="button-form">
            <button id="submit">Войти</button>
          <div id="reg">
            У Вас еще нет аккаунта?
            <router-link class="enter" to="/registration">Зарегистрироваться </router-link>
          </div>
        </div>
      </form>
    </div>
  </div>
  <footer>
    <v-footer/>
  </footer>
</template>

<script>
import {getUser} from "../services/reg_auth.js";
import useVuelidate from '@vuelidate/core'
import {required, email, minLength} from '@vuelidate/validators'
import { reactive, computed } from 'vue'
import {mapMutations} from 'vuex'

import VFooter from "../components/v-footer.vue";

export default {
  name: "RegistrationView",

  setup() {
    const state = reactive({
      input__email: "",
      input__password: "",
    })

    const rules = computed(() => {
      return {
        input__email: { required, email },
        input__password: { required, minLength: minLength(6) },
      }
    })

    const v$ = useVuelidate(rules, state)

    return {
      state, v$,
    }
  },

  methods: {
    ...mapMutations(["updateUser"]),

    async authorization() {
      this.v$.$validate()
      if(!this.v$.$error){

        const response = await getUser(this.state.input__email, this.state.input__password);

        console.log(response[0].user[0]);

        this.updateUser(response[0].user[0]);

        if(response[0].type === 1){
          alert(response[0].message);
        } else {
          alert('Вы авторизованы');
          this.$router.push("/profile?id=" + response[0].user[0].ID);
        }

      } else {
        alert('Проверьте правильность заполнения полей');
      }
    }
  },

  components: {
    VFooter,
  }

}
</script>

<style scoped>

.container__auth {
  width: 100%;
  height: 100vh;
  display: flex;
  flex-direction: column;
}

.login-box {
  margin: 7% auto;
  width: 400px;
  border-radius: 10px;
}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: black;
  text-align: center;
  font-family: "DIN PRO Medium";
  font-size: 30px;
}

.login-box .user-box input {
  position: relative;
  width: 100%;
  font-size: 16px;
  color: black;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid black;
  outline: none;
  background: transparent;
}

.login-box .user-box label {
  position: relative;
  left: 0;
  top: -60px;
  padding: 10px 0;
  font-size: 16px;
  color: #a6a6a6;
  pointer-events: none;
  transition: .5s;
  font-family: "DIN PRO Regular";
}

.login-box .user-box input:focus~label,
.login-box .user-box input:valid~label {
  top: -85px;
  left: 0;
  color: #913259;
  font-size: 12px;
}

.button-form {
  display: flex;
  justify-content: center;
  flex-direction: column;
  margin: 0 auto;
}

#submit {
  padding: 15px 40px;
  color: white;
  text-decoration: none;
  overflow: hidden;
  transition: .5s;
  background: black;
  font-family: "DIN PRO Medium";
  font-size: 14px;
  margin: 0 auto;
}

#submit:hover {
  background: #913259;
  color: #ffffff;
}

.router__submit {
  margin: 0 auto;
}

#reg {
  margin: 15px auto;
  font-family: "DIN PRO Regular";
}
.enter {
  text-decoration: none;
  color: black;
  font-family: "DIN PRO Medium";
  transition: .2s;
}

.enter:hover {
  color: #913259;

}

. {
  font-size: 14px;
  text-decoration: none;
  color: #CBBDDB;
  margin: auto;
  width: 60%;
  text-align: center;
}

.invalid__data {
  color: #d34339;
  margin-top: -35px;
  font-family: 'DIN PRO Regular';
  font-size: 14px;
  margin-bottom: 50px;
}

</style>
