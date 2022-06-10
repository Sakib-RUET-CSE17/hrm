/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import 'bootstrap';
import firebase from 'firebase/compat/app';
import * as firebaseui from 'firebaseui';
import 'firebaseui/dist/firebaseui.css';

// // start the Stimulus application
import './bootstrap';
import firebaseConfig from '../config/auth/firebaseConfig';

// Import the functions you need from the SDKs you need
// import { initializeApp } from "firebase/app";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration

// Initialize Firebase
const app = firebase.initializeApp(firebaseConfig);

// FirebaseUI config.
var uiConfig = {
    signInOptions: [
        firebase.auth.GoogleAuthProvider.PROVIDER_ID,
        firebase.auth.FacebookAuthProvider.PROVIDER_ID,
        firebase.auth.GithubAuthProvider.PROVIDER_ID,
        firebase.auth.EmailAuthProvider.PROVIDER_ID,
        {
            provider: 'phone',
            defaultCountry: 'BD',
        }
    ],
    // tosUrl and privacyPolicyUrl accept either url string or a callback
    // function.
    // Terms of service url/callback.
    tosUrl: '<your-tos-url>',
    // Privacy policy url/callback.
    privacyPolicyUrl: function () {
        window.location.assign('<your-privacy-policy-url>');
    },

    callbacks: {
        signInSuccessWithAuthResult: function (authResult) {
            // console.log(authResult);
            // throw new Error('stop execution');
            firebase.auth().currentUser.getIdToken(/* forceRefresh */ true).then(function (idToken) {
                // console.log(authResult);
                // thnew Error('error getting')
                // Send token to your backend via HTTPS
                location.replace(`/firebase_auth/${idToken}/${authResult.user.email || authResult.user.phoneNumber}`);
            }).catch(function (error) {
                console.log(error.message);
            });
            return false;
        }
    }
};

// Initialize the FirebaseUI Widget using Firebase.
var ui = new firebaseui.auth.AuthUI(firebase.auth(app));
// The start method will wait until the DOM is loaded.
if (document.getElementById('firebaseui-auth-container')) {
    ui.start('#firebaseui-auth-container', uiConfig);
}