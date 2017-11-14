#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>

#define THREAD_NUM 5

int sum_val[THREAD_NUM];
int a[10][10] = {{0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9},
                {0, 1, 2, 3, 4, 5, 6, 7, 8, 9}};

void *sum(void *input) {
    int i;
    int tmp = 0;
    int row = (int)input;

    for (i = 0; i < 10; i++) {
        tmp += a[row*2][i] + a[row*2 + 1][i];
    }

    printf("thread %d, value = %d\n", row, tmp);
    sum_val[row] = tmp;

    pthread_exit(NULL);
}

void main() {
    pthread_t tid[THREAD_NUM];
    pthread_attr_t attr;
    int i;
    int total = 0;

    pthread_attr_init(&attr);

    for (i = 0; i < 5; i++) {
        pthread_create(&tid[i], &attr, sum, (void *)i);

        pthread_join(tid[i], NULL);
    }

    for (i = 0; i < 5; i++) {
        total += sum_val[i];
    }

    printf("total result is %d\n", total);

    exit(0);
}
