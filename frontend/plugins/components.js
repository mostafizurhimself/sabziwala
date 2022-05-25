import Vue from "vue";

// Components
import SectionHeader from "~/components/shared/SectionHeader.vue";
import TheProduct from "~/components/shared/TheProduct.vue";
import TheBanner from "~/components/shared/TheBanner.vue";
import DropdownComp from "~/components/shared/DropdownComp.vue";
import ModalComp from "~/components/shared/ModalComp.vue";
import Badge from "~/components/shared/Badge.vue";
import Truncate from "~/components/shared/Truncate.vue";
import SocialShare from "~/components/shared/SocialShare.vue";
import Loading from "~/components/layouts/Loading.vue";

// Forms
import InputField from "~/components/forms/InputField";
import ButtonField from "~/components/forms/ButtonField";
import CheckboxField from "~/components/forms/CheckboxField";
import ImageField from "~/components/forms/ImageField";
import SelectField from "~/components/forms/SelectField";
import TextField from "~/components/forms/TextField";
import ImageAttachField from "~/components/forms/ImageAttachField";
import PaymentMethodButton from "~/components/forms/PaymentMethodButton.vue";
import WishlistButton from "~/components/forms/WishlistButton.vue";

Vue.component("section-header", SectionHeader);
Vue.component("the-product", TheProduct);
Vue.component("the-banner", TheBanner);
Vue.component("dropdown-comp", DropdownComp);
Vue.component("modal-comp", ModalComp);
Vue.component("the-badge", Badge);
Vue.component("truncate", Truncate);
Vue.component("social-share", SocialShare);
Vue.component("Loading", Loading);

// Forms
Vue.component("input-field", InputField);
Vue.component("button-field", ButtonField);
Vue.component("checkbox-field", CheckboxField);
Vue.component("image-field", ImageField);
Vue.component("select-field", SelectField);
Vue.component("text-field", TextField);
Vue.component("image-attach-field", ImageAttachField);
Vue.component("payment-method-button", PaymentMethodButton);
Vue.component("wishlist-button", WishlistButton);


// icons
import Facebook from "~/components/icons/Facebook";
import Instagram from "~/components/icons/Instagram";
import Twitter from "~/components/icons/Twitter";
import CartIcon from "~/components/icons/CartIcon";
import PlusIcon from "~/components/icons/PlusIcon";
import MinusIcon from "~/components/icons/MinusIcon";
import EmailIcon from "~/components/icons/EmailIcon";
import PhoneIcon from "~/components/icons/PhoneIcon";
import HomeIcon from "~/components/icons/HomeIcon";
import WalletIcon from "~/components/icons/WalletIcon";
import RightIcon from "~/components/icons/RightIcon";
import LeftIcon from "~/components/icons/LeftIcon";
import InfoIcon from "~/components/icons/InfoIcon";
import EmailClosed from "~/components/icons/EmailClosed";

Vue.component("Facebook", Facebook);
Vue.component("Instagram", Instagram);
Vue.component("Twitter", Twitter);
Vue.component("CartIcon", CartIcon);
Vue.component("PlusIcon", PlusIcon);
Vue.component("MinusIcon", MinusIcon);
Vue.component("EmailIcon", EmailIcon);
Vue.component("PhoneIcon", PhoneIcon);
Vue.component("HomeIcon", HomeIcon);
Vue.component("WalletIcon", WalletIcon);
Vue.component("RightIcon", RightIcon);
Vue.component("LeftIcon", LeftIcon);
Vue.component("InfoIcon", InfoIcon);
Vue.component("EmailClosed", EmailClosed);
