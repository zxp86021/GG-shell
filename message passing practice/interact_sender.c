#include <stdio.h>
#include <sys/msg.h>
#include <stdlib.h>
#include <string.h>
#include "msg_buf.h"

int main() {
    int msgqid;
    key_t key = 0x123;
    int msgflag = IPC_CREAT|0666;
    struct msqid_ds buf;
    int ret;
    char input[MSGSIZE];
    struct msgbuf mbuf;

    if ((msgqid = msgget(key, msgflag)) < 0) {
        printf("message queue create failed \n");
        exit(-1);
    } else {
        printf("message queue created, queue id is %d \n", msgqid);

        ret = msgctl(msgqid, IPC_STAT, &buf);

        if (ret == 0) {
            printf("message ctl with IPC_STAT success \n");
        } else {
            printf("message ctl with IPC_STAT fail \n");
        }

        buf.msg_qbytes = MSGSIZE * MSGNUM;

        ret = msgctl(msgqid, IPC_SET, &buf);

        if (ret == 0) {
            printf("message ctl with IPC_SET success \n");
        } else {
            printf("message ctl with IPC_SET fail \n");
        }

        fprintf(stderr, "message to send: ");

        while(fgets(input, MSGSIZE, stdin)) {
            if (strcmp(input, "exit\n") == 0) {
                ret = msgctl(msgqid, IPC_RMID, &buf);

                if (ret == 0) {
                    printf("message ctl with IPC_RMID success \n");
                } else {
                    printf("message ctl with IPC_RMID fail \n");
                }

                exit(0);
            }

            mbuf.mtype = 1;

            strcpy(mbuf.mtext, input);

            ret = msgsnd(msgqid, &mbuf, sizeof(mbuf.mtext), 0);

            if (ret == 0) {
                printf("message send success \n");
            } else {
                printf("message send fail \n");
            }

            fprintf(stderr, "message to send: ");
        }
    }

    return 0;
}
