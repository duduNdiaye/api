<template>
  <div id="app" class="bg-gray-100">
    <div class="bg-white h-screen flex flex-col p-6 space-y-5">
      <div class="flex items-center justify-center">
        <span class="bg-black text-white p-3 text-3xl font-bold">DouTech</span>
      </div>
      <div class="text-gray-600 body-font flex space-x-16 justify-center items-center">
        <div class="flex flex-col space-y-5 justify-center items-center p-12">
          <!-- les ecritures et le bouton -->
          <div class="flex flex-col space-y-6">
            <div
              class="text-black font-extrabold text-xl lg:text-5xl traking-[13px] leading-[1.1]"
            >
              <span>Trouvez ici toutes les technologies de dernieres generations</span>
            </div>
            <p class="text-black">
              Cette plateforme vous permet de trouver toutes les produits informatiques
              dont vous aurez besoin. La plateforme dispose de produits de differentes
              categories, et permet de commander ces produits.
            </p>
          </div>
          <div class="lg:ml-[-26rem]">
            <button
              v-if="token == null"
              type="button"
              @click="connexion = true"
              class="text-black text-xl hover:bg-gray-600 hover:scale-105 transition duration-100 hover:text-white p-3 border-2 border-black font-bold"
            >
              Se connecter
            </button>
            <button
              v-if="token == null"
              @click="inscription = true"
              type="button"
              class="ml-4 mt-4 text-black text-xl hover:bg-gray-600 hover:scale-105 transition duration-100 hover:text-white p-3 border-2 border-black font-bold"
            >
              S'inscrire
            </button>
            <button
              v-if="token"
              @click="Deconnexion()"
              type="button"
              class="mt-4 text-black text-xl hover:bg-gray-600 hover:scale-105 transition duration-100 hover:text-white p-3 border-2 border-black font-bold"
            >
              Se deconnecter
            </button>
          </div>
        </div>
        <div class="mr-36">
          <img src="./acceui.png" alt="" class="w-11/12 justify-center" />
        </div>
      </div>
    </div>
  </div>
  <section v-if="token">
    <div class="w-full bg-gray-100 h-fit px-4 pb-8 mb-12 lg:p-8" id="default">
      <span class="font-bold text-3xl">Les produits disponibles</span>
      <div
        id="results"
        class="mt-5 mb-10 grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
      >
        <article
          v-for="prod in produits"
          :key="prod.id"
          class="product-card hover:scale-105 rounded-md mb-5 shadow-xl duration-100 p-3 cart-type-neon overflow-hidden bg-white"
        >
          <span
            class="block overflow-hidden w-auto lg:h-56 bg-transparent opacity-100 lg:m-0 lg:p-0 lg:inset-0 m-0 p-0 inset-0"
          >
            <button class="rounded-md">
              <img
                :src="prod.photo"
                alt="Product image"
                class="w-[32rem] h-40 mb-6 product-image"
              />
            </button>
            <header
              class="md:p-6 lg:mt-[-3rem] mt-[-1.5rem] lg:ml-[-1.4rem] lg:mr-[-1.4rem]"
            >
              <div class="flex spaec-x-4">
                <span class="text-lg lg:text-xl font-semibold text-heading md:text-base">
                  {{ prod.nom }}</span
                >
                <div class="flex space-x-1 bg-gray-200 rounded-full px-2 ml-auto mt-2">
                  <span
                    class="text-black font-bold text-sm flex items-center justify-center"
                    >{{ prod.prix }}F</span
                  >
                </div>
              </div>
              <div class="flex">
                <div class="flex space-x-3">
                  <span>{{ prod.categorie }}</span>
                </div>
              </div>
            </header>
          </span>
        </article>
      </div>
    </div>
  </section>
  <transition name="panierr">
    <div
      v-if="inscription"
      class="w-full fixed top-4 z-[51] lg:left-80 md:left-36 max-w-2xl rounded-xl h-fit bg-white p-6 md:p-12 mt-16"
    >
      <div class="flex items-center justify-center sm:mb-10">
        <span class="lg:text-xl font-bold sm:text-xl bg-black text-white p-2">
          inscription
        </span>
      </div>

      <div class="space-y-2 h-[20rem] flex flex-col w-full">
        <div class="flex space-x-4"></div>
        <input
          v-model="form.name"
          autocomplete="off"
          placeholder="Nom*"
          type="text"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />

        <input
          v-model="form.email"
          autocomplete="off"
          placeholder="example@gmail.com"
          type="email"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />
        <input
          v-model="form.password"
          autocomplete="off"
          placeholder="Mot de passe*"
          type="password"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />
        <input
          v-model="form.password_confirmation"
          placeholder="confirmer mot de passe*"
          autocomplete="off"
          type="password"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />
        <button
          @click="(inscription = false), register()"
          class="inline-flex mt-5 px-4 py-2 text-black border-2 hover:scale-105 transition duration-100 hover:text-white border-black items-center justify-center hover:bg-gray-600 font-bold"
        >
          S'inscrire
        </button>
      </div>
    </div>
  </transition>
  <div
    @click.self="inscription = false"
    v-if="inscription"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
  <transition name="panierr">
    <div
      v-if="connexion"
      class="w-full fixed top-4 z-[51] lg:left-80 md:left-36 max-w-2xl rounded-xl h-[25rem] bg-white p-6 md:p-12 mt-16"
    >
      <div class="flex items-center justify-center sm:mb-10">
        <span class="lg:text-xl font-bold sm:text-xl bg-black text-white p-2">
          Connexion
        </span>
      </div>

      <div class="space-y-2 h-[20rem] flex flex-col w-full">
        <div class="flex space-x-4"></div>
        <input
          v-model="login.email"
          placeholder="email*"
          type="text"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />

        <input
          v-model="login.password"
          placeholder="mot de passe*"
          type="password"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />
        <button
          @click="(connexion = false), Connexion()"
          class="inline-flex mt-5 px-4 py-2 text-black border-2 hover:scale-105 transition duration-100 hover:text-white border-black items-center justify-center hover:bg-gray-600 font-bold"
        >
          Se connecter
        </button>
      </div>
    </div>
  </transition>
  <div
    @click.self="connexion = false"
    v-if="connexion"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
  name: "App",
  components: {},
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      login: {
        email: "",
        password: "",
      },
      inscription: false,
      connexion: false,
      token: null,
      produits: [],
    };
  },

  mounted() {
    console.log("salut!");
  },
  methods: {
    register() {
      console.log("inscription");
      axios
        .post("api/user/inscription", this.form)
        .then((response) => {
          console.log(response.data);
          console.log("les donnees sont la");
        })
        .catch((error) => {
          console.log(error.response.data);
          // afficher les erreurs de validation
        });
    },

    Connexion() {
      console.log("connexion");
      axios
        .post("api/user/connexion", this.login)
        .then((response) => {
          console.log(response.data);
          console.log("les donnees sont la d!");
          const token = response.data.token;
          localStorage.setItem("token", token);
          const msg = response.data.message;
          this.token = token;
          localStorage.setItem("token", token);
          console.log(token);
          if (msg === "Authentification réussie") {
            this.LoadRessource();
          }
        })
        .catch((error) => {
          console.log(error.response.data);
          // afficher les erreurs de validation
        });
    },
    LoadRessource() {
      console.log("Bonjour");
      axios
        .get("api/produits")
        .then((response) => {
          console.log(response.data);
          console.log("les data sont la d!");

          this.produits = response.data;
        })
        .catch((error) => {
          console.log(error.response.data);
          // afficher les erreurs de validation
        });
    },
    Deconnexion() {
      console.log("merci");
      const token = localStorage.getItem("token");
      const headers = {
        Authorization: `Bearer ${token}`,
      };
      axios
        .post("api/user/deconnexion", { title: "Deconnexion" }, { headers })
        .then((response) => {
          console.log(response.data);
          console.log("ciao!");
          this.token = null;
          const msg = response.data.message;
          console.log(msg);
        })
        .catch((error) => {
          console.log(error.response.data);
          // afficher les erreurs de validation
        });
    },
  },
};
</script>
<style>
.panierr-enter-active,
.panierr-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
  transform: translateY(-20%);
  opacity: 0;
}

.panierr-enter,
.panierr-leave-to {
  opacity: 0;
  transform: translateY(-20%);
}

.panierr-leave,
.panierr-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>
