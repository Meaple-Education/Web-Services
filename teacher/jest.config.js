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
            branches: 1,
            functions: 1,
            lines: 1,
            statements: 1,
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
    ],
    reporters: ["default", "jest-junit"],
    coverageReporters: [
        "json",
        "lcov",
        "text",
        "clover"
    ],
};
