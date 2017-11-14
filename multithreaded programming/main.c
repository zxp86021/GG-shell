#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>

int sum, factorial;

void *summer(void *input) {
    int i;

    int number = atoi((char *)input);

    for (i = 1; i <= number; i++) {
        sum += i;
    }

    pthread_exit(NULL);
}

void *facter(void *input) {
    int i;

    int number = atoi((char *)input);

    int tmp = 1;

    for (i = 2; i <= number; i++) {
        tmp *= i;
    }

    factorial = tmp;

    pthread_exit(NULL);
}

void main(int argc, char *argv[]) {
    pthread_t tid_sum, tid_fac;
    pthread_attr_t attr;
    void *ret;

    if (argc != 2) {
        printf("QAQ"); 
        exit(-1);
    }

    if (atoi(argv[1]) < 0) {
        printf("QQ");
        exit(-1);
    }

    pthread_attr_init(&attr);

    pthread_create(&tid_sum, &attr, summer, argv[1]);

    pthread_join(tid_sum, NULL);

    pthread_create(&tid_fac, &attr, facter, argv[1]);

    pthread_join(tid_fac, NULL);

    printf("sum result is %d\n", sum);

    printf("factorial result is %d\n", factorial);

    exit(0);
}
