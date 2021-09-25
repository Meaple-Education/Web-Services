export const PageEndpoint: { [key: string]: string } = {
    home: '/',
    signup: '/auth/sign-up',
    signin: '/auth/sign-in',
    verifyAccount: '/auth/verify-account',
    profile: '/profile',
    dashboard: '/:schoolID',
    studentList: '/:schoolID/student',
    studentCreate: '/:schoolID/student/create',
    studentDetail: '/:schoolID/student/:studentID',
}
