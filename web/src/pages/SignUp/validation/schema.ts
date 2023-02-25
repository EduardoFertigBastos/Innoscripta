import * as Yup from 'yup';

export const schema = Yup.object().shape({
    email: Yup.string().required().email(),
    password: Yup.string()
        .min(8, 'The password must contain at least 8 digits!')
        .matches(/(?=.*[a-z])/, 'The password must contain a lowercase letter')
        .matches(/(?=.*[A-Z])/, 'Password must contain an uppercase'),
    passwordConfirmation: Yup.string()
        .oneOf([Yup.ref('password'), null], 'The entered passwords must be the same!'),
    name: Yup.string().required(),
});