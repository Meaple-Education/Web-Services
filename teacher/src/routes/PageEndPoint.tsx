export const PageEndpoint: { [key: string]: string } = {
    home: '/',
    schoolList: '/dashboard',
    signup: '/auth/sign-up',
    signin: '/auth/sign-in',
    verifyAccount: '/auth/verify-account',
    verifyPassword: '/auth/verify-password',
    profile: '/profile',
    dashboard: '/dashboard/:schoolID',
    classList: '/dashboard/:schoolID/class',
    classCreate: '/dashboard/:schoolID/class/create',
    classDetail: '/dashboard/:schoolID/class/:classID',
    studentList: '/dashboard/:schoolID/student',
    studentCreate: '/dashboard/:schoolID/student/create',
    studentDetail: '/dashboard/:schoolID/student/:studentID',
    gurdianList: '/dashboard/:schoolID/gurdian',
    gurdianCreate: '/dashboard/:schoolID/gurdian/create',
    gurdianDetail: '/dashboard/:schoolID/gurdian/:gurdianID',
    staffList: '/dashboard/:schoolID/staff',
    staffCreate: '/dashboard/:schoolID/staff/create',
    staffDetail: '/dashboard/:schoolID/staff/:staffID',
    setting: '/dashboard/:schoolID/setting',
}

export const BuildPath = (path: string, params: { [key: string]: string | number } = {}) => {
    Object.entries(params).forEach((v) => {
        path = path.replace(':' + v[0], v[1].toString());
    });

    return path;
}
