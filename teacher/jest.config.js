module.exports = {
    preset: 'ts-jest',
    testEnvironment: 'jsdom',
    verbose: true,
    roots: ["<rootDir>/src/", "<rootDir>/__tests__/"],
    transform: {
        '^.+\\.tsx?$': 'ts-jest',
    },
    testRegex: '(/__tests__/.*|(\\.|/)(test|spec))\\.tsx?$',
    moduleFileExtensions: ['ts', 'tsx', 'js', 'jsx', 'json', 'node'],
    testPathIgnorePatterns: ["<rootDir>/__tests__/utils/"],
    coverageThreshold: {
        global: {
            branches: 85,
            functions: 75,
            lines: 85,
            statements: 85,
        },
    },
    collectCoverageFrom: [
        './**/*.{js,jsx,ts,tsx}',
        '!./__tests__/**',
        '!./public/**',
        '!./style/**',
        '!./**/*.config.js',
        '!./**/*.d.ts',
        '!./node_modules/**',
        '!./src/index.tsx',
        '!./src/reportWebVitals.ts',
        '!./src/setupTests.ts',
        '!./src/App.tsx',
        '!./src/routes/Routes.tsx',
    ],
    reporters: ["default", "jest-junit"],
    coverageReporters: [
        "json",
        "lcov",
        "text",
        "clover"
    ],
};
