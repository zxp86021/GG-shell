#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <unistd.h>
#include <string.h>

void main() {
    int i;
	pid_t pid;
    char input[100];

    fprintf(stderr, "richegg-shell $ ");

    while(scanf("%s", input)) {
        if (strcmp(input, "exit") == 0) {
            exit(0);
        }

        pid = fork();

        if (pid == 0) {
            execlp(input, input, NULL);
            exit(0);
        } else {
            wait(NULL);
        }

        fprintf(stderr, "richegg-shell $ ");
    }
}
