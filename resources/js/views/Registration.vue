<template>
<div class="container__reg">
  <div class="login-box">
    <h2>Регистрация</h2>
    <form @submit.prevent="registration">
      <div class="user-box">
        <input v-model.trim="state.input__name" type="text" name="">
        <label>Имя</label>
        <p v-if="v$.input__name.$error" class="invalid__data">Проверьте правильность полей</p>
      </div>
      <div class="user-box">
        <input class="is__invalid" v-model.trim="state.input__surname" type="text" name="">
        <label>Фамилия</label>
        <p v-if="v$.input__surname.$error" class="invalid__data">Проверьте правильность полей</p>
      </div>
      <div class="user-box">
        <input class="is__invalid" v-model.trim="state.input__email" type="text" name="">
        <label>Email</label>
        <p v-if="v$.input__email.$error" class="invalid__data">Проверьте правильность полей</p>
      </div>
      <div class="user-box">
        <input class="is__invalid" v-model.trim="state.input__password" type="password" name="">
        <label>Пароль</label>
        <p v-if="v$.input__password.$error" class="invalid__data">Проверьте правильность полей</p>
      </div>
      <div class="user-box">
        <input class="is__invalid" v-model.trim="state.input__password__repeat" type="password" name="">
        <label>Повторите пароль</label>
        <p v-if="v$.input__password__repeat.$error" class="invalid__data">Поле пустое или пароли не совпадают</p>
      </div>
      <div class="button-form">

          <button id="submit" >Зарегистрироваться</button>

        <div id="auth">
          У Вас есть аккаунт?
          <router-link class="enter" to="/authorization">Войти </router-link>
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
import {postUser} from "../services/reg_auth.js";
import useVuelidate from '@vuelidate/core'
import { required, email, minLength, sameAs } from '@vuelidate/validators'
import { reactive, computed } from 'vue'

import VFooter from "../components/v-footer.vue";
// import axios from "axios";

export default {
  name: "RegistrationView",

  data() {
    return {
      reg: /[А-Яа-яA-Za-z]/,
    }
  },

  setup() {
    const state = reactive({
      input__name: "",
      input__surname: "",
      input__email: "",
      input__password: "",
      input__password__repeat: "",

    })

    const rules = computed(() => {
      return {
        input__name: { required },
        input__surname: { required },
        input__email: { required, email },
        input__password: { required, minLength: minLength(6) },
        input__password__repeat: { required, sameAs: sameAs(state.input__password) },
      }
    })

    const v$ = useVuelidate(rules, state)

    return {
      state, v$,
    }
  },

  methods: {
    async registration() {
      this.v$.$validate()
      console.log(!this.v$.$error, this.reg.test(this.state.input__name), this.reg.test(this.state.input__surname));
      if(!this.v$.$error && this.reg.test(this.state.input__name) && this.reg.test(this.state.input__surname)){

        const response = await postUser(this.state.input__name, this.state.input__surname, this.state.input__email, this.state.input__password);
        console.log(response[0].type);

        if(response[0].type == 1){
          alert(response[0].message);
        }else {
          alert('Вы зарегистрированы');
          //document.location.href = './authorization';
          this.$router.push("/authorization");
        }

      } else {
        alert('Проверьте правильность заполнения формы');
      }

    }
  },


  components: {
    VFooter,
  },
}
</script>

<style scoped>

.container__reg {
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

.router__submit{
  margin: 0 auto;
}

#auth {
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
