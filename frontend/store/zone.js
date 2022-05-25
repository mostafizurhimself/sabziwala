// states
export const state = () => ({
    selectedZone: null,
    showModal: false,
});

// getters
export const getters = {
    getSelectedZone(state) {
        return state.selectedZone;
    },
    showZoneModal(state) {
        return state.showModal;
    },
};

// mutations
export const mutations = {
    SET_SELECTED_ZONE(state, zone) {
        state.selectedZone = zone;
        this.$cookies.set("selected-zone", state.selectedZone, {
            path: "/",
            maxAge: 60 * 60 * 24,
        });
    },

    TOGGLE_ZONE_MODAL(state) {
        state.showModal = !state.showModal;
    },
};

// actions
export const actions = {
    setSelectedZone(context, payload) {
        context.commit('SET_SELECTED_ZONE', payload);
    },

    toggleZoneModal(context) {
        context.commit('TOGGLE_ZONE_MODAL')
    }
};
