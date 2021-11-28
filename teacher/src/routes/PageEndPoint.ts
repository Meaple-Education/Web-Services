export const PageEndpoint: { [key: string]: string } = {
    home: '/',
    schoolList: '/dashboard',
    signup: '/auth/sign-up',
    signin: '/auth/sign-in',
    verifyAccount: '/auth/verify-account',
    verifyPassword: '/auth/verify-password',
    profile: '/profile',
    dashboard: '/dashboard/:schoolID',
    studentList: '/dashboard/:schoolID/student',
    studentCreate: '/dashboard/:schoolID/student/create',
    studentDetail: '/dashboard/:schoolID/student/:studentID',
}
