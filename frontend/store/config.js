export const state = () => ({
  settings: null,
  enums: null,
  options: null,
  appearances: null,
  howItWorks: null,
  workWithUs: null,
  riderFaqs: null,
  aboutFaqs: null,
  whyChooseUs: null,
  featureProducts: [],
  cities: []
});

// Getters
export const getters = {
  getHeroSection(state) {
    return state.appearances?.find(item => item.name == 'hero');
  },

  getAppSection(state) {
    return state.appearances?.find(item => item.name == 'app_section');
  },

  getRiderHeroSection(state) {
    return state.appearances?.find(item => item.name == 'rider_hero');
  },

  getRiderAppSection(state) {
    return state.appearances?.find(item => item.name == 'rider_apps');
  },

  getContactPageHero(state) {
    return state.appearances?.find(item => item.name == 'contact_page_hero');
  },

  getOwnerSection(state) {
    return state.appearances?.find(item => item.name == 'owner_section');
  },

  getAboutPageHero(state) {
    return state.appearances?.find(item => item.name == 'about_page_hero');
  },

  getTermsAndCondition(state) {
    return state.appearances?.find(item => item.name == 'terms_conditions');
  },

  getPaymentAndRefunds(state) {
    return state.appearances?.find(item => item.name == 'payment_refunds');
  },

  getWorkWithUs(state) {
    return state.workWithUs;
  },

  getRiderFaqs(state) {
    return state.riderFaqs;
  },

  getWebsiteSettings(state) {
    return state.settings?.find(item => item.name == "website");
  },

  getCurrency(state) {
    return state.settings?.find(item => item.name == 'currency');
  },

  getPaymentMethod(state) {
    return state.enums.paymentMethod;
  },

  getHowItWorks(state) {
    return state.howItWorks;
  },

  getAboutFaqs(state) {
    return state.aboutFaqs;
  },

  whyChooseUs(state) {
    return state.whyChooseUs;
  },

  getFeatureProducts(state) {
    return state.featureProducts;
  },

  getCities(state) {
    return state.cities;
  },
};

// Mutations
export const mutations = {
  SET_STATE(state, config) {
    state.settings = config.settings;
    state.enums = config.enums;
    state.options = config.options;
    state.appearances = config.appearances;
    state.howItWorks = config.howItWorks;
    state.workWithUs = config.workWithUs;
    state.riderFaqs = config.riderFaqs;
    state.aboutFaqs = config.aboutFaqs;
    state.whyChooseUs = config.whyChooseUs;
    state.featureProducts = config.featureProducts;
    state.cities = config.cities;
  }
};

// Actions
export const actions = {
  async setConfig({ commit }, { url }) {
    try {
      const resConfig = await this.$axios.$get(url);
      commit("SET_STATE", resConfig.data);
    } catch (error) {
      console.log(error);
    }
  }
};
