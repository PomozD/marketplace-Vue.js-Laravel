<template>
  <div class="first-screen">
    <div class="wrapper">
      <h1>Сверхлегкая ткань</h1>
      <p>Правильное количество тепла <br> для занятий спортом в холодных условиях</p>
    </div>
  </div>

  <div class="services">
    <div class="services_list">
      <router-link class="service__mans" id="btn-mans" to="/catalog/Мужчины">
        <div class="div__link">Мужчины</div>
        <button class="button_primary">Перейти к покупкам</button>
      </router-link>
      <router-link class="service__womans" id="btn-womans" to="/catalog/Женщины">
        <div class="div__link">Женщины</div>
        <button class="button_primary">Перейти к покупкам</button>
      </router-link>
      <router-link class="service__kids" id="btn-kids" to="/catalog/Дети">
        <div class="div__link">Дети</div>
        <button class="button_primary">Перейти к покупкам</button>
      </router-link>
      <router-link class="service__accessories" id="btn-accessories" to="/catalog/Аксессуары">
        <div class="div__link">Аксессуары</div>
        <div class="button_primary">Перейти к покупкам</div>
      </router-link>
    </div>
  </div>

  <div class="joining bg-parallax overlay">
    <div class="joining__text">
      <h1>Присоединяйтесь к нам в соцсетях</h1>
      <div class="join__icons">
        <a class="join__facebook" href="https://ru-ru.facebook.com/">
          <img class="icon__facebook" src="../assets/icons-facebook.svg">
        </a>
        <a class="join__instagram" href="https://www.instagram.com/">
          <img class="icon__instagram" src="../assets/icons-instagram.svg">
        </a>
        <a class="join__vk" href="https://vk.com/">
          <img class="icon__vk" src="../assets/icons-vk.svg">
        </a>
      </div>
    </div>
  </div>
  <footer>
    <v-footer/>
  </footer>
</template>

<script>
import VFooter from "../components/v-footer.vue";
export default {
  name: 'MainView',
  components: {VFooter},
}
</script>

<style>
a {
  text-decoration: none;
}

/*wrapper*/

.first-screen {
  position: relative;
  background-image: url(../assets/main_photo.png);
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  min-height: 80vh;
}
.wrapper {
  position: absolute;
  width: 80%;
  margin-top: 250px;
  margin-left: 50px;
}
.wrapper h1 {
  font-family: "DIN PRO Medium";
  font-size: 76px;
  line-height: 36px;
  color: #ffffff;
}
.wrapper p {
  margin: 30px 0;
  font-family: "DIN PRO Medium";
  font-size: 32px;
  font-weight: 800;
  line-height: 35px;
  color: #ffffff;
}

/* services */

.services {
  display: flex;
  justify-content: center;
}

.services_list {
  display: flex;
  margin-top: 50px;
}

.service__mans {
  background-image: url(../assets/mans.png);
}
.service__womans {
  background-image: url(../assets/womans.png);
}
.service__kids {
  background-image: url(../assets/kids.png);
}
.service__accessories {
  background-image: url(../assets/accessories.png);
}
.service__mans, .service__womans ,.service__kids, .service__accessories {
  display: flex;
  text-align: center;
  justify-content: center;
  align-items: center;
  background-size: cover;
  background-repeat: no-repeat;
  min-height: 306px;
  min-width: 306px;
  margin: 20px;
  transition: .5s;
}
.service__mans .div__link, .service__womans .div__link,.service__kids .div__link, .service__accessories .div__link {
  position: relative;
  color: #ffffff;
  font-family: "DIN PRO Medium";
  font-size: 28px;
  margin-left: 20px;
  transition: .5s;
}

.service__mans:hover .div__link, .service__womans:hover .div__link,.service__kids:hover .div__link,
.service__accessories:hover .div__link {
  display: none;
}

.button_primary {
  color: black;
  margin: 0 auto;
  display: none;
  font-family: "DIN PRO Medium";
  font-size: 15px;
  background: #ffffff;
  padding: 20px 35px;
  border: none;
  outline: none;
  cursor: pointer;
  transition: .2s;
}


.service__mans:hover .button_primary, .service__womans:hover .button_primary,.service__kids:hover .button_primary,
.service__accessories:hover .button_primary {
  display: block;
}

/* popular */

.container__popular {
  display: flex;
  align-items: center;
}
.popular {
  width: 93%;
  margin: 0 auto;
}

/*joining*/

.joining {
  margin-top: 50px;
  position: relative;
  background-image: url(../assets/kolaj.png);
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
  min-height: 100vh;
}
.joining.bg-parallax {
  background-attachment: fixed;
}
.joining__text {
  position: absolute;
  width: 100%;
  text-align: center;
  top: 45%;
}
.joining__text h1 {
  font-family: "DIN PRO Medium";
  font-size: 76px;
  line-height: 66px;
  color: #ffffff;
}
.join__icons {
  margin-top: 100px;
}
.join__facebook, .join__instagram, .join__vk {
  top: 10%;
  margin: 0 75px 0 75px;
}
</style>
