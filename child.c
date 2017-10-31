#include <stdio.h> 
#include <stdlib.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <unistd.h>

void main() {
    int i, j;
    pid_t pid, pid1, pid2, pid3, pid4, pid5, pid6;

    for (i = 0; i < 3; i++) {
        pid = fork();

        if (pid == 0) {
            if (i == 0) { 
                pid1 = fork();

                if (pid1 == 0) {
                    printf("\n  PID_4=%d complete!\n", getpid());
                    exit(0);
                } else {
                    wait(NULL);
                }
                
                printf("\n  PID_1=%d complete!\n", getpid());
                exit(0);
            }

            if (i == 1) {
                for (j = 0; j < 2; j++) {
                    pid2 = fork();

                    if (pid2 == 0) {
                        printf("\n  PID_%d=%d complete!\n", j+5, getpid());
                        exit(0);
                    } else {
                        wait(NULL);
                    }
                }
                
                printf("\n  PID_2=%d complete!\n", getpid());
                exit(0);
            }

            if (i == 2) {
                printf("\n  PID_3=%d complete!\n", getpid());
                exit(0);
            }
        } else {
            wait(NULL);
        }
    }

    printf("\n  PID_0=%d complete!\n", getpid());   
}

